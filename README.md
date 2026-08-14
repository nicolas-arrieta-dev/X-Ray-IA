# X-Ray-IA

Sistema web para el análisis y gestión de radiografías, desarrollado como herramienta de apoyo para el diagnóstico médico mediante inteligencia artificial.

La plataforma funciona como un visor de análisis de radiografías que permite editar y manipular imágenes médicas de forma profesional. Además, cuenta con módulos para la gestión de pacientes, usuarios, diagnósticos y patologías.

El sistema integra un modelo de inteligencia artificial capaz de analizar radiografías en tiempo real, identificando la clase de fractura o trauma y señalando la ubicación donde se presenta. Esta funcionalidad está orientada a servir como herramienta de apoyo para hospitales de primer nivel.

## Características

### Visor y análisis de radiografías

El sistema cuenta con un visor especializado para el análisis de imágenes radiográficas, permitiendo:

- Visualizar radiografías.
- Editar y manipular las imágenes.
- Realizar análisis visual de las radiografías.
- Utilizar herramientas orientadas al análisis profesional de imágenes médicas.

### Gestión de pacientes

El sistema permite administrar la información de los pacientes, incluyendo:

- Registrar pacientes.
- Consultar pacientes.
- Actualizar información.
- Eliminar pacientes.
- Gestionar la información asociada a los diagnósticos.

### Gestión de diagnósticos y patologías

La plataforma permite administrar la información utilizada para los diagnósticos médicos:

- Crear nuevos diagnósticos.
- Registrar nuevas patologías.
- Gestionar las patologías existentes.
- Asociar información de diagnóstico con los pacientes.

### Inteligencia Artificial
- Python
- Flask
- Keras
- YOLO
- Redes neuronales convolucionales (CNN)
- Dataset: https://www.kaggle.com/datasets/orvile/human-bone-fractures-image-dataset-hbfmid/data

El modelo permite:

- Analizar radiografías en tiempo real.
- Detectar fracturas y traumas.
- Identificar la clase de fractura o trauma.
- Determinar la ubicación de la lesión en la radiografía.
- Mostrar los resultados del análisis directamente en el sistema.

El servicio de inteligencia artificial está desarrollado en Python utilizando Flask y se comunica con la aplicación web mediante una API.

## Tecnologías

### Aplicación web

- PHP
- MySQL
- HTML
- CSS
- JavaScript

### Inteligencia Artificial

- Python
- Flask
- Modelo de inteligencia artificial para análisis de radiografías

### Base de datos

- MySQL
- Procedimientos almacenados (Stored Procedures)

## Arquitectura del proyecto

El proyecto está compuesto principalmente por dos partes:

```text
X-Ray-IA
│
├── Proyecto PHP
│   └── Aplicación web
│
├── x-ray_ia
│   ├── modelo actual
│   └── modelo_api.py
│
└── procedimientos
    ├── Base de datos MySQL
    └── Scripts SQL y procedimientos almacenados
```
## Colaboración

Este proyecto fue desarrollado en colaboración con:

Nicolás Arrieta (Me) 
GitHub: https://github.com/nicolas-arrieta-dev

Jorge Morales 
GitHub: https://github.com/ingjorgemorales

Participamos en el desarrollo de la plataforma, integrando el sistema web, la gestión de información, el visor de radiografías y el componente de inteligencia artificial para el análisis de imágenes médicas.

<img width="640" height="640" alt="dab1e2ce8c0f78f710ed" src="https://github.com/user-attachments/assets/4ae87933-bf4d-4495-8f20-16ae4fce3182" />
<img width="597" height="340" alt="image" src="https://github.com/user-attachments/assets/89f03acb-dfac-4f4b-8d1a-17d98596bc84" />
<img width="567" height="253" alt="image" src="https://github.com/user-attachments/assets/ac30dafb-e315-4f38-8887-442f37130ec5" />
<img width="567" height="251" alt="image" src="https://github.com/user-attachments/assets/8795959a-711b-461e-99ed-ec07fb944c54" />
<img width="567" height="254" alt="image" src="https://github.com/user-attachments/assets/2d6184c0-15f7-436d-bff9-bedf0b15137b" />
<img width="567" height="251" alt="image" src="https://github.com/user-attachments/assets/ca96be53-8b3a-4ebd-8d6a-7913592cca6a" />
<img width="567" height="254" alt="image" src="https://github.com/user-attachments/assets/63f7847d-56be-47a4-a7e4-e7e03f79a6ba" />
<img width="567" height="252" alt="image" src="https://github.com/user-attachments/assets/2b881912-fad0-4877-90bb-4fc6d6a126f5" />
<img width="567" height="249" alt="image" src="https://github.com/user-attachments/assets/ec785d62-5c74-486b-a207-df3972972bbf" />







