from ultralytics import YOLO
import cv2

# D:\pyton\python.exe "d:/Poryectos de ia/x-ray_ia/app.py"
model = YOLO("modelo_x-ray3.pt")  

imagen = "./548bf612-5551-49e1-8378-508cd54d8be0.jpeg"  


results = model(imagen)


for r in results:
    im_array = r.plot()  
    cv2.imshow("Detección", im_array)
    cv2.waitKey(0)

cv2.destroyAllWindows()
