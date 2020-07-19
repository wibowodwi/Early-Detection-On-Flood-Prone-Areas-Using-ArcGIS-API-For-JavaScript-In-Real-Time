# Early Detection On Flood Prone Areas Using ArcGIS API For JavaScript In Real Time
Penerapan IOT (Internet Of Things) dan GIS (Geographic Information System) digunakan dalam memonitor ketinggian air secara real-time dan peringatan otomatis.

![image](https://user-images.githubusercontent.com/50950100/87878592-69688880-ca0f-11ea-9cee-6b531b0f0645.png)
![image](https://user-images.githubusercontent.com/50950100/87878609-8bfaa180-ca0f-11ea-916e-72a4cb8daa28.png)

![image](https://user-images.githubusercontent.com/50950100/87877944-6d92a700-ca0b-11ea-8474-f76c626157f5.png "Arsitektur")

# Metode normalisasi data statistik
Pada proses menampilkan notifikasi pada web, sistem menggunakan metode normalisasi data statik yang bertujuan untuk memastikan ketinggian air yang didapat. Metode ini menghitung persebaran data. Persebaran data yang jauh satu sama lain mengindikasikan bahwa data tidak stabil.

![image](https://user-images.githubusercontent.com/50950100/87878282-77b5a500-ca0d-11ea-9249-5ae8a23a43d3.png)

![image](https://user-images.githubusercontent.com/50950100/87878260-581e7c80-ca0d-11ea-8e89-77f2b99d08c8.png)

# Sistem komunikasi menggunakan MQTT
Protokol MQTT (Message Queuing Telemetry Transport) adalah protokol yang berjalan pada diatas stack TCP/IP dan mempunyai ukuran paket data dengan low overhead yang kecil (minimum 2 bytes) sehingga berefek pada konsumsi catu daya yang juga cukup kecil.
Protokol ini adalah jenis protokol data-agnostic yang artinya anda bisa mengirimkan data apapun seperti data binary, text bahkan XML ataupun JSON dan protokol ini memakai model publish/subscribe daripada model client-server.

# ArcGIS API For JavaScript
ArcGIS menyediakan beberapa API yang bisa digunakan. Fitur yang adapun lebih lengkap dan bisa dipakai di beberapa platform.
Untuk dokumentasi lengkap bisa dilihat di https://developers.arcgis.com/javascript/
