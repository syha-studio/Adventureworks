# Adventureworks, FP_DWO_KELOMPOK_3
<p>Final Project Pengembangan Data Warehouse dan Dashboard Adventureworks (Sales And Production)</p>
<p>Dibuat oleh Kelompok 3<br>
Program Studi Sistem Informasi<br>
Fakultas Ilmu Komputer<br>
UPN "Veteran" Jawa Timur<br>
Nama Ketua :<br>
Syauqillah Hadie Ahsana (21082010042)<br>
Nama Anggota :<br>
Aisyah Azzahra Prasetyo (21082010024)<br>
Alya Fatin Fadhiyah Muhaimin Putri (21082010027)<br>
Maulana Bryan Syahputra (21082010038)</p>

<p>Langkah-langkah yang dibutuhkan untuk menjalankan app dengan baik :</p>

<p>1. Install database server: MySql (disini kami menggunakan Xampp versi terbaru).<br>
2.Install software mysql management: phpMyAdmin dari Xampp (ATAU YG LAIN).<br>
3.Download semua file pada repository ini.<br>
4.Buat Folder pada htdocs XAMPP (xampp/htdocs) dengan nama adventureworks.
5.Letakkan semua file ke folder yang anda buat(kecuali folder file OLAP dan Database).<br>
6.Jalankan Xampp control panel.<br>
7.Start apache dan mysql server.<br>
8.Buka phpMyAdmin (localhost/phpmyadmin).<br>
9.Buat database dengan nama adventureworks_dw.<br>
10.Import file adventureworks_dw.sql (file berada di dalam folder file OLAP dan Database) ke dalam database adventureworks_dw.<br>
11.Letakkan file mondrian.war (file berada di dalam folder file OLAP dan Database) ke dalam server Tomcat bawaan dari XAMPP (xampp/tomcat/webapps).<br>
12.Start tomcat melalui Xampp, tunggu hingga folder mondrian selesai dibuat di \tomcat\webapps\, Stop tomcat.<br>
13.Letakkan file mysql-connector-java-5.1.4-bin.jar (file berada di dalam folder file OLAP dan Database) ke dalam \tomcat\webapps\mondrian\WEB-INF\lib<br>
14.Letakkan semua file pada folder [file OLAP and database/mondrian files/WEB-INF/queries] ke dalam \tomcat\webapps\mondrian\WEB-INF\queries.<br>
15.Letakkan semua file pada folder [file OLAP and database/mondrian files/mondrian] ke dalam \tomcat\webapps\mondrian\<br>
16.Start Tomcat dan Jalankan Aplikasi dengan mengakses http://localhost/adventureworks</p>
