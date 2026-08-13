from flask import Flask, request, jsonify
from flask_cors import CORS
from ultralytics import YOLO
import numpy as np
import cv2
import base64
import re
import json 
import time  
app = Flask(__name__)
CORS(app)

#D:\pyton\python.exe "d:/Poryectos de ia/x-ray_ia/modelo_api.py"
# Cargar modelo YOLO
model = YOLO("modelo_x-ray3.pt")

@app.route('/predict', methods=['POST'])
def predict():
    if 'file' not in request.files:
        return jsonify({"error": "No se ha enviado ninguna imagen"}), 400

    file = request.files['file']
    if file.filename == '':
        return jsonify({"error": "Nombre de archivo vacío"}), 400

    file_bytes = np.frombuffer(file.read(), np.uint8)
    img = cv2.imdecode(file_bytes, cv2.IMREAD_COLOR)
    if img is None:
        return jsonify({"error": "Archivo de imagen inválido"}), 400

    # Medir tiempo de inferencia
    inicio_inferencia = time.time()
    results = model(img, conf=0.25)
    fin_inferencia = time.time()
    tiempo_inferencia_ms = round((fin_inferencia - inicio_inferencia) * 1000, 2)

    # Diagnóstico
    class_names = model.names
    diagnostico = []
    for r in results:
        if r.boxes is not None and r.boxes.cls is not None:
            clases = r.boxes.cls.cpu().numpy().astype(int).tolist()
            confianzas = r.boxes.conf.cpu().numpy().tolist()

            diagnostico = [
                {"clase": class_names[c], "confianza": round(conf, 2)}
                for c, conf in zip(clases, confianzas)
            ]
        else:
            diagnostico = [{"clase": "No se detectaron anomalías", "confianza": 0.0}]

        im_array = r.plot()
        _, im_buf = cv2.imencode('.jpg', im_array)
        img_base64 = base64.b64encode(im_buf).decode('utf-8')

        det_info = {
            "imagen": f"{r.orig_shape[1]}x{r.orig_shape[0]}",
            "clases_detectadas": ", ".join([class_names[c] for c in set(clases)]) if clases else "Ninguna",
            "tiempo_inferencia": f"{tiempo_inferencia_ms} ms"
        }

        speed_info = {
            "preprocesamiento": "N/D",
            "inferencia": f"{tiempo_inferencia_ms} ms",
            "postprocesamiento": "N/D",
            "shape": str(r.orig_shape)
        }

    respuesta = {
        "diagnostico": diagnostico,
        "imagen": img_base64,
        "salida_modelo": "",
        "resultado_modelo": {
            "deteccion": det_info,
            "velocidades": speed_info
        }
    }

    print(json.dumps(respuesta, indent=4, ensure_ascii=False))  # Imprimir JSON en consola

    return jsonify(respuesta)
if __name__ == '__main__':
    app.run(debug=True)
