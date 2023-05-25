<?php

class Database
{
    private $connection;

    //Membuat koneksi database

    public function __construct($database)
    {
        $this->connection = mysqli_connect("localhost", "root", "", $database);

        if (!$this->connection) {
            die("Koneksi database gagal: " . mysqli_connect_error());
        }
    }

    public function create($table, $data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        $values = array_values($data);

        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        $stmt = mysqli_prepare($this->connection, $query);

        if (!$stmt) {
            die("Kesalahan dalam mempersiapkan statement: " . mysqli_error($this->connection));
        }

        $this->bindParams($stmt, $values);

        if (!mysqli_stmt_execute($stmt)) {
            die("Kesalahan dalam menjalankan statement: " . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
    }

    public function read($table, $conditions = [])
    {
        $query = "SELECT * FROM $table";

        if (!empty($conditions)) {
            $query .= " WHERE " . $this->buildCondition($conditions);
        }

        $result = mysqli_query($this->connection, $query);

        if (!$result) {
            die("Kesalahan dalam menjalankan query: " . mysqli_error($this->connection));
        }

        $rows = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }

        mysqli_free_result($result);

        return $rows;
    }
    public function selectOne($table, $conditions = [])
    {
        $where = $this->buildCondition($conditions);
        $query = "SELECT * FROM $table WHERE $where LIMIT 1";

        $stmt = mysqli_prepare($this->connection, $query);

        if (!$stmt) {
            die("Kesalahan dalam mempersiapkan statement: " . mysqli_error($this->connection));
        }

        $this->bindParams($stmt, array_values($conditions));

        if (!mysqli_stmt_execute($stmt)) {
            die("Kesalahan dalam menjalankan statement: " . mysqli_stmt_error($stmt));
        }

        $result = mysqli_stmt_get_result($stmt);

        if (!$result) {
            die("Kesalahan dalam mengambil hasil: " . mysqli_error($this->connection));
        }

        $row = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);

        return $row;
    }
    public function selectCount($table)
    {
        $query = "SELECT COUNT(*) AS total FROM $table";

        $result = mysqli_query($this->connection, $query);

        if (!$result) {
            die("Kesalahan dalam menjalankan query: " . mysqli_error($this->connection));
        }

        $row = mysqli_fetch_assoc($result);
        $total = $row['total'];

        mysqli_free_result($result);

        return $total;
    }

    public function selectSum($table, $column)
    {
        $query = "SELECT SUM($column) as total FROM $table";

        $result = mysqli_query($this->connection, $query);

        if (!$result) {
            die("Kesalahan dalam menjalankan query: " . mysqli_error($this->connection));
        }

        $row = mysqli_fetch_assoc($result);

        mysqli_free_result($result);

        return $row['total'];
    }

    public function selectCountDistinct($table, $column, $alias = null)
    {
        if ($alias) {
            $query = "SELECT COUNT(DISTINCT $column) as $alias FROM $table";
        } else {
            $query = "SELECT COUNT(DISTINCT $column) FROM $table";
        }

        $result = mysqli_query($this->connection, $query);

        if (!$result) {
            die("Kesalahan dalam menjalankan query: " . mysqli_error($this->connection));
        }

        $row = mysqli_fetch_assoc($result);

        mysqli_free_result($result);

        if ($alias) {
            return $row[$alias];
        } else {
            return reset($row); // Mengembalikan nilai pertama dari array asosiatif
        }
    }

    public function innerJoin($table, $joinTable = [], $joinCondition)
    {
        $query = "SELECT * FROM $table INNER JOIN $joinTable ON $joinCondition";

        $result = mysqli_query($this->connection, $query);

        if (!$result) {
            die("Kesalahan dalam menjalankan query: " . mysqli_error($this->connection));
        }

        $rows = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }

        mysqli_free_result($result);

        return $rows;
    }

    public function update($table, $data, $conditions = [])
    {
        $set = $this->buildSet($data);
        $where = $this->buildCondition($conditions);

        $query = "UPDATE $table SET $set WHERE $where";

        $stmt = mysqli_prepare($this->connection, $query);

        if (!$stmt) {
            die("Kesalahan dalam mempersiapkan statement: " . mysqli_error($this->connection));
        }

        $this->bindParams($stmt, array_merge(array_values($data), array_values($conditions)));

        if (!mysqli_stmt_execute($stmt)) {
            die("Kesalahan dalam menjalankan statement: " . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
    }

    public function delete($table, $conditions = [])
    {
        $where = $this->buildCondition($conditions);

        $query = "DELETE FROM $table WHERE $where";

        $stmt = mysqli_prepare($this->connection, $query);

        if (!$stmt) {
            die("Kesalahan dalam mempersiapkan statement: " . mysqli_error($this->connection));
        }

        $this->bindParams($stmt, array_values($conditions));

        if (!mysqli_stmt_execute($stmt)) {
            die("Kesalahan dalam menjalankan statement: " . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
    }

    private function bindParams($stmt, $params)
    {
        $types = str_repeat("s", count($params));
        $values = [];

        foreach ($params as $param) {
            $values[] = &$param;
        }

        array_unshift($values, $stmt, $types);

        call_user_func_array('mysqli_stmt_bind_param', $values);
    }

    private function buildCondition($conditions)
    {
        $condition = "";

        foreach ($conditions as $column => $value) {
            $condition .= "$column = ? AND ";
        }

        return rtrim($condition, " AND ");
    }

    private function buildSet($data)
    {
        $set = "";

        foreach ($data as $column => $value) {
            $set .= "$column = ?, ";
        }

        return rtrim($set, ", ");
    }
}


class Healthy
{

    public function bmi()
    {
        $hasil = "";
        if (
            isset($_POST['submit']) && isset($_POST['kelamin'])
            && isset($_POST['tb']) && ($_POST['bb'])
        ) {
            $kelamin   = $_POST['kelamin'];
            $tb        = $_POST['tb'];
            $bb        = $_POST['bb'];
            if (($kelamin != null) && ($tb != null) && ($tb >= 110) && ($bb != null) && ($bb >= 12)) {

                // Input form

                /* Rumus BMI adalah:
                BMI = BERAT BADAN / KUADRAT TINGGI BADAN m
                */
                $tb = $tb / 100;
                $tbcm = $tb * 100;
                // Hitung BMI

                $bmia        = $bb / ($tb * $tb);
                $bmi         = number_format($bmia, 2);

                /*Hitung BB ideal sesuai jenis kelamin dengan rumus broca
            
                notes : tinggi badan dalam cm
                wanita = (tinggi badan - 100 )-(15%*(tinggi badan-100))
                pria = (tinggi badan - 100 )-(10%*(tinggi badan-100))
                */

                if ($kelamin == "Perempuan") {
                    $bbideal = ($tbcm - 100) - (0.15 * ($tbcm - 100));
                } elseif ($kelamin == "Laki-laki") {
                    $bbideal = ($tbcm - 100) - (0.1 * ($tbcm - 100));
                }

                if ($bmi < 16) {
                    $hasil = "Berat Banda Anda Masuk Kategori Sangat Kurus. Berat Badan Anda Seharusnya $bbideal";
                } elseif ($bmi >= 16.00 && $bmi <= 16.99) {
                    $hasil = "Berat Badan Anda Masuk Kategori Kurus. Berat Badan Anda Seharusnya $bbideal";
                } elseif ($bmi >= 17.00 && $bmi <= 18.49) {
                    $hasil = "Berat Badan Anda Masuk Kategori Sedikit Kurus. Berat Badan Anda Seharusnya $bbideal";
                } elseif ($bmi >= 18.50 && $bmi <= 24.99) {
                    $hasil = "Berat Badan Anda Masuk Kategori Normal. Berat Badan Anda yaitu $bb";
                } elseif ($bmi >= 25 && $bmi <= 29.99) {
                    $hasil = "Berat Badan Anda Masuk Kategori Kelebihan Berat Badan. Berat Badan Anda Seharusnya $bbideal";
                } elseif ($bmi >= 30 && $bmi <= 34.99) {
                    $hasil = "Berat Badan Anda Masuk Kategori Obesitas Kelas 1. Berat Badan Anda Seharusnya $bbideal";
                } elseif ($bmi >= 35 && $bmi <= 39.99) {
                    $hasil = "Berat Badan Anda Masuk Kategori Obesitas Kelas 2. Berat Badan Anda Seharusnya $bbideal";
                } else {
                    $hasil = "Berat Badan Anda Masuk Kategori Obesitas Kelas 3. Berat Badan Anda Seharusnya $bbideal";
                }
            }
            return $hasil;
        }
    }

    public function calories()
    {



        if ((isset($_POST['submit'])) && isset($_POST['category'])
            && isset($_POST['bb']) && isset($_POST['tb'])
        ) {

            $category       = $_POST['category'];
            $bb             = $_POST['bb'];
            $durasi         = $_POST['tb'];

            // Input form

            /* Rumus Menghitung Kalori Kegiatan :
    
            EC = {[MET x 7.7 x BB(pound)] / 200} x waktu berolah raga
            
            */

            $convertbb = $durasi / 60;


            if ($category == "olahraga") {

                $ket = "Olahraga";


                $activityData = array(
                    array("Panahan", 4.69),
                    array("Badminton", 5.5),
                    array("Basket", 6.5),
                    array("Billiard", 2.5),
                    array("Bowling", 3.74),
                    array("Boxing", 7.8),
                    array("Coaching", 4.0),
                    array("Chearleading", 6.0),
                    array("Futsal", 8.0),
                    array("Baseball", 2.5),
                    array("Golf", 4.8),
                    array("Gymnastic", 3.8),
                    array("Berkuda(Berlari)", 5.8),
                    array("Berkuda(Berjalan)", 3.8),
                    array("Karate", 6.28),
                    array("Taekwondo", 9.97),
                    array("Judo", 11.14),
                    array("Sepak Bola", 10.0),
                    array("Pingpong", 4.0),
                    array("Tennis", 7.3),
                    array("Volli", 4.0)
                );
            } else  if ($category == "home") {

                $ket = "Aktivitas di Rumah";


                $activityData = array(
                    array("Menyapu Lantai", 3.3),
                    array("Mencuci Mobil", 3.5),
                    array("Mengepel Lantai", 3.5),
                    array("Membersihkan Debu", 2.3),
                    array("Memasak", 3.4),
                    array("Mencuci Piring", 3.4),
                    array("Belanja Pangan", 3.3),
                    array("Menggosok", 1.8),
                    array("Menjahit Baju", 2.8),
                    array("Mencuci Baju (Mesin)", 2.2),
                    array("Mencuci Baju (Tangan)", 2.64),
                    array("Menjemur Baju", 4.62),
                    array("Mengangkat Pakaian", 2.3),
                    array("Merapihkan Tempat Tidur", 2.1),
                    array("Memindahkan Furniture", 5),
                    array("Merapihkan Ruangan", 4.8),
                    array("Menyikat Lantai", 3.52),
                    array("Menyapu Halaman", 6.5),
                    array("Menyiram Tanaman", 2.5),
                    array("Bermain Dengan Anak (Duduk)", 2.2),
                    array("Bermain Dengan Anak (Berdiri)", 2.8)
                );
            } else  if ($category == "inactive") {

                $ket = "Tidak Aktif";

                $activityData = array(
                    array("Berbaring Sambil Menonton TV", 1),
                    array("Duduk Tanpa Aktivitas Lain", 1.3),
                    array("Duduk Sambil Menonton Film di Bioskop", 1.5),
                    array("Tidur", 0.95),
                    array("Berdiri Tanpa Aktivitas Lain", 1.3),
                    array("Menulis", 1.3),
                    array("Bermeditasi", 1),
                    array("Berbicara", 1.3),
                    array("Duduk Sambil Merokok", 1.3),
                    array("Duduk Sambil Menonton TV", 1.3),
                    array("Duduk Sambil Mendengarkan Musik/Radio", 1.5),
                    array("Berbaring Sambil Mendengarkan Musik", 1.01),
                    array("Duduk Dengan Kaki Gelisah", 1.8),
                    array("Membaca", 1.3),
                    array("Berbaring Tanpa Aktivitas", 1.3)
                );
            } else  if ($category == "berkebun") {

                $ket = "Berkebun";

                $activityData = array(
                    array("Memotong Kayu Bakar", 4.6),
                    array("Membawa Kayu", 5.5),
                    array("Menggali", 3.6),
                    array("Menggali Untuk Irigasi", 3.53),
                    array("Menggali Tanah Untuk Tanaman", 4.28),
                    array("Mengendarai Tractor", 2.8),
                    array("Menanam Tumbuhan", 4.3),
                    array("Menanam Pohon", 4.5),
                    array("Menyapu Daun", 3.8),
                    array("Menyiram Taman", 1.5),
                    array("Berkebun", 3.8),
                    array("Panen Buah", 3.5),
                    array("Memangkas Semak", 4),
                    array("Memotong Rumput", 5),
                    array("Menebang Pohon Besar", 8.3)
                );
            } else  if ($category == "menari") {

                $ket = "Menari";

                $activityData = array(
                    array("Ballet (Rehearsel atau Kelas)", 5),
                    array("Ballet (Perfomace)", 6.8),
                    array("Aerobic", 7.3),
                    array("Berdansa", 5.5),
                    array("Modern Dance Class (Cowo)", 6.3),
                    array("Aerobic Dance", 5),
                    array("Menari (Waltz)", 4.5),
                    array("Tarian Rakyat", 9.6),
                    array("Tarian Budaya", 4.5),
                    array("Modern Dance Class (Women)", 5)
                );
            } else  if ($category == "berkendara") {

                $ket = "Berkendara";

                $activityData = array(
                    array("Mengendarai Mobil", 2.62),
                    array("Mengendarai BUS", 1.3),
                    array("Mengendarai Kereta", 1.3),
                    array("Menerbangkan Pesawat", 2.05),
                    array("Menerbangkan Helicopter", 1.44),
                    array("Mengendarai Motor", 3.19),
                    array("Mengendarai Becak", 6.3),
                    array("Mengendarai Tank", 2.03),
                    array("Mengendarai Truck Tentara", 2.87),
                    array("Mendorong Pesawat Masuk dan Keluar Hangar", 6)
                );
            } else  if ($category == "volunteer") {

                $ket = "Volunteer";

                $activityData = array(
                    array("Meeting/Terlibat Pembicaraan", 1.5),
                    array("Bermain Dengan Anak", 3.5),
                    array("Mengetik (Manual/Komputer)", 1.3),
                    array("Duduk Sambil Mengurus Anak", 2),
                    array("Mengepack Box", 3),
                    array("Menata Kursi", 3),
                    array("Berjalan/Berdiri Untuk Tujuan Sukarela", 3),
                    array("Duduk, Pekerjaan Kantor Ringan", 1.5),
                    array("Melakukan Pekerjaan Berat", 4.5),
                    array("Membenarkan Barang Rusak", 3)
                );
            } else  if ($category == "agama") {

                $ket = "Agama";

                $activityData = array(
                    array("Duduk Mengikuti Acara Keagamaan", 1.3),
                    array("Duduk Sambil Membaca Kitab", 1.3),
                    array("Sholat", 1.3),
                    array("Menyanyi di Gereja (Berdiri)", 2),
                    array("Membersihkan Rumah Ibadah", 3.3)
                );
            } else  if ($category == "berjalan") {

                $ket = "Berjalan";

                $activityData = array(
                    array("Backpacking", 7),
                    array("Mendaki Gunung Dengan Membawa Tas", 7.8),
                    array("Mendorong Stroller Anak", 4),
                    array("Gerak Jalan", 6.5),
                    array("Berjalan Membawa Peliharaan", 3),
                    array("Menonton Pertunjukan Burung Sambil Berjalan", 2.5),
                    array("Membawa Barang (7kg) Ke Lantai Bawah", 5),
                    array("Membawa Barang Ke Lantai Atas", 8.3),
                    array("Berjalan Sambil Menggendong Anak (4kg)", 2.38),
                    array("Baris Berbaris Dalam Militer (Tanpa Kelompok)", 8)
                );
            } else  if ($category == "berlari") {

                $ket = "Berlari";

                $activityData = array(
                    array("Jogging", 7),
                    array("Berlari 4mph (13 min/mile)", 6),
                    array("Berlari 5mph (12 min/mile)", 8.3),
                    array("Berlari 6mph (10 min/mile)", 9.8),
                    array("Berlari 7mph (8.5 min/mile)", 11),
                    array("Berlari 8mph (7.5 min/mile)", 11.8),
                    array("Berlari 9mph (6.5 min/mile)", 12.8),
                    array("Berlari 10mph (6 min/mile)", 14.5),
                    array("Berlari 11mph (5.5 min/mile)", 16),
                    array("Berlari 12mph (5 min/mile)", 19),
                    array("Berlari 13mph (4.6 min/mile)", 19.8),
                    array("Berlari 14mph (4.3 min/mile)", 23),
                    array("Berlari Menaiki Tangga", 15),
                    array("Marathon", 13.3),
                    array("Berlari Pada Track", 10)
                );
            } else  if ($category == "music") {

                $ket = "Bermain Alat Musik";

                $activityData = array(
                    array("Melakukan Orchestra (Berdiri)", 2.3),
                    array("Bermain Drum", 3.8),
                    array("Bermain Piano (Duduk)", 2.3),
                    array("Bermain Organ (Duduk)", 2),
                    array("Bermain Violin (Duduk)", 2.5),
                    array("Bermain Trompet (Duduk)", 1.8),
                    array("Bermain Flute (Duduk)", 2),
                    array("Marching Band", 5.5),
                    array("Bermain Gitar (Duduk)", 2),
                    array("Bermain Gitar (Berdiri)", 3)
                );
            } else  if ($category == "bekerja") {

                $ket = "Bekerja";

                $activityData = array(
                    array("Pramugari Maskapai Penerbangan", 3),
                    array("Polisi (Mengatur Lalu Lintas)", 5),
                    array("Membuat Roti", 4),
                    array("Tukang Kayu", 4.3),
                    array("Petugas Pembersih Kamar Hotel", 4),
                    array("Chef", 2.5),
                    array("Petani", 7.8),
                    array("Engineer", 1.8),
                    array("Pemadam Kebakaran", 8),
                    array("Hairstylist", 1.8),
                    array("Sekretaris", 2.2),
                    array("Bekerja Didepan Komputer", 1.03),
                    array("Pelukis", 3.61),
                    array("Petugas Perpustakaan", 2.2),
                    array("Petugas Laundry", 3.3),
                    array("Penjahit", 2.5),
                    array("Tukang Pijat", 4),
                    array("Tukang Sampah", 4),
                    array("Petugas LAB (Men)", 2.11),
                    array("Petugas LAB (Women)", 1.38),
                    array("Petugas POS", 2.3)
                );
            } else  if ($category == "self") {

                $ket = "Self Care";

                $activityData = array(
                    array("Mandi", 1.5),
                    array("Memakai Baju", 2.5),
                    array("Makan (Duduk)", 1.5),
                    array("Menyikat Gigi", 2),
                    array("Menata Rambut (Berdiri)", 2.5),
                    array("Minum Obat", 1.5),
                    array("Makan Sambil Berbicara", 2),
                    array("Memakai Make Up", 2),
                    array("Bercukur", 2),
                    array("Bersiap Untuk Tidur", 3)
                );
            } else  if ($category == "water") {

                $ket = "di Air";

                $activityData = array(
                    array("Diving", 3),
                    array("Perlombaan Berlayar", 4.5),
                    array("Surfing", 5),
                    array("Snorkeling", 5),
                    array("Berenang Gaya Punggung", 7.15),
                    array("Berenang Gaya Bebas", 7.8),
                    array("Bermain Bola Volly di Air", 3),
                    array("Jet Skiing Driving", 7),
                    array("Mendayung Perahu", 4),
                    array("Menyelam", 11.53)
                );
            } else  if ($category == "winter") {

                $ket = "Winter Activity";

                $activityData = array(
                    array("Skatting", 7),
                    array("Skiing", 4.5),
                    array("Bermain Kereta Luncur", 5),
                    array("Memindahkan Rumah Es", 5),
                    array("Memancing Ikan di Es", 7.15)
                );
            } else  if ($category == "sepeda") {

                $ket = "Bicycling";



                $activityData = array(
                    array("Bersepeda di Gunung", 14),
                    array("Balapan Sepeda di Gunung", 16),
                    array("Bersepeda dari/ke Kantor", 6.8),
                    array("Bersepeda", 7.5),
                    array("Bersepeda, BMX", 8.5)
                );
            } else  if ($category == "latihan") {

                $ket = "Conditioning Exercise";

                $activityData = array(
                    array("Yoga", 2.1),
                    array("Bersepeda Menggunakan Spinning Bike", 7),
                    array("Push Up", 3.8),
                    array("Pull Up", 8),
                    array("Stair Treadmill", 9),
                    array("Lompat Tali", 111),
                    array("Sit Up", 8),
                    array("Bermain Dace Revolution (Arcade Games)", 7.2),
                    array("Aerobic", 3.4),
                    array("Mendayung", 7.3)
                );
            } else  if ($category == "fishhunt") {

                $ket = "Memancing dan Berburu";

                $activityData = array(
                    array("Memancing", 3.5),
                    array("Menangkap Ikan Dengan Tangan", 4),
                    array("Menangkap Ikan Dari Kapal (Duduk)", 2),
                    array("Berburu", 5),
                    array("Berburu Rusa", 6),
                    array("Berburu Burung", 3.3),
                    array("Menembak", 2.5),
                    array("Berburu Kelinci", 5),
                    array("Mencari Cacing", 4.3),
                    array("Berburu Hewan Laut Berukuran Besar", 4)
                );
            } else  if ($category == "lainnya") {

                $ket = "Kegiatan Lainnya";

                $activityData = array(
                    array("Bermain Kartu (Duduk)", 1.5),
                    array("Bermain Catur (Duduk)", 1.5),
                    array("Menggambar (Duduk)", 1.8),
                    array("Membaca Buku/Koran (Duduk)", 1.3),
                    array("Mengcopy Dokumen (Berdiri)", 1.5),
                    array("Bermain Komputer", 1),
                    array("Duduk Didalam Kelas Sambil Mencatat", 1.8),
                    array("Menjahit Baju", 1.54),
                    array("Membaca (Berdiri)", 1.8),
                    array("Berbicara Di Telepone (Duduk)", 1.5)
                );
            }

            foreach ($activityData as $index => $activity) {
                $ec = $activity[1] * $convertbb * $bb;
                $activityName = $activity[0];
                $hasil[$index] = "$activityName = " . number_format($ec, 2);
            }

            $data = array(
                'hasil' => $hasil,
                'keterangan' => $ket,
            );
            return $data;
        }
    }


    public function heartDisplay()
    {



        if ((isset($_POST['submit'])) && (isset($_POST['kelaminHeart']))
            && (isset($_POST['usiaHeart'])) && (isset($_POST['atletHeart']))
            && (isset($_POST['kategoriHeart']))
        ) {
            // Input form

            $kelamin   = $_POST['kelaminHeart'];
            $usia      = $_POST['usiaHeart'];
            $atlet     = $_POST['atletHeart'];
            $kategori  = $_POST['kategoriHeart'];

            if ($atlet == "ya") {

                if ($kategori = "satu") {
                    $hasilkategori = "1 - 2 Tahun";
                } elseif ($kategori = "dua") {
                    $hasilkategori = "3 - 4 Tahun";
                } elseif ($kategori = "tiga") {
                    $hasilkategori = "5 - 6 Tahun";
                } elseif ($kategori = "empat") {
                    $hasilkategori = "7 - 9 Tahun";
                }
                if ($kategori = "lima") {
                    $hasilkategori = "10 Tahun Keatas";
                }

                $detaknormalbawah = "40";
                $detaknormalatas = "60";

                $detakmax = 220 - $usia;

                //SEDANG

                $sedangMin = ((($detakmax - $detaknormalbawah) * 0.50) + $detaknormalbawah) - ((($detakmax - $detaknormalbawah) * 0.69) + $detaknormalbawah);
                $sedangMax = ((($detakmax - $detaknormalatas) * 0.50) + $detaknormalatas) - ((($detakmax - $detaknormalatas) * 0.69) + $detaknormalatas);

                //BERAT

                $atasMin = ((($detakmax - $detaknormalbawah) * 0.70) + $detaknormalbawah) - ((($detakmax - $detaknormalbawah) * 0.85) + $detaknormalbawah);
                $atasMax = ((($detakmax - $detaknormalatas) * 0.70) + $detaknormalatas) - ((($detakmax - $detaknormalatas) * 0.85) + $detaknormalatas);
            } elseif ($kategori == "satu") {

                $hasilkategori = "1 - 2 Tahun";

                $detaknormalbawah = "80";
                $detaknormalatas = "130";

                $detakmax = 220 - $usia;

                //SEDANG

                $sedangMin = ((($detakmax - $detaknormalbawah) * 0.50) + $detaknormalbawah) - ((($detakmax - $detaknormalbawah) * 0.69) + $detaknormalbawah);
                $sedangMax = ((($detakmax - $detaknormalatas) * 0.50) + $detaknormalatas) - ((($detakmax - $detaknormalatas) * 0.69) + $detaknormalatas);

                //BERAT

                $atasMin = ((($detakmax - $detaknormalbawah) * 0.70) + $detaknormalbawah) - ((($detakmax - $detaknormalbawah) * 0.85) + $detaknormalbawah);
                $atasMax = ((($detakmax - $detaknormalatas) * 0.70) + $detaknormalatas) - ((($detakmax - $detaknormalatas) * 0.85) + $detaknormalatas);
            } elseif ($kategori == "dua") {

                $hasilkategori =  "3 - 4 Tahun";

                $detaknormalbawah = "80";
                $detaknormalatas = "120";

                $detakmax = 220 - $usia;

                //SEDANG

                $sedangMin = ((($detakmax - $detaknormalbawah) * 0.50) + $detaknormalbawah) - ((($detakmax - $detaknormalbawah) * 0.69) + $detaknormalbawah);
                $sedangMax = ((($detakmax - $detaknormalatas) * 0.50) + $detaknormalatas) - ((($detakmax - $detaknormalatas) * 0.69) + $detaknormalatas);

                //BERAT

                $atasMin = ((($detakmax - $detaknormalbawah) * 0.70) + $detaknormalbawah) - ((($detakmax - $detaknormalbawah) * 0.85) + $detaknormalbawah);
                $atasMax = ((($detakmax - $detaknormalatas) * 0.70) + $detaknormalatas) - ((($detakmax - $detaknormalatas) * 0.85) + $detaknormalatas);
            } elseif ($kategori == "tiga") {

                $hasilkategori = "5 - 6 Tahun";

                $detaknormalbawah = "75";
                $detaknormalatas = "115";

                $detakmax = 220 - $usia;

                //SEDANG

                $sedangMin = ((($detakmax - $detaknormalbawah) * 0.50) + $detaknormalbawah) - ((($detakmax - $detaknormalbawah) * 0.69) + $detaknormalbawah);
                $sedangMax = ((($detakmax - $detaknormalatas) * 0.50) + $detaknormalatas) - ((($detakmax - $detaknormalatas) * 0.69) + $detaknormalatas);

                //BERAT

                $atasMin = ((($detakmax - $detaknormalbawah) * 0.70) + $detaknormalbawah) - ((($detakmax - $detaknormalbawah) * 0.85) + $detaknormalbawah);
                $atasMax = ((($detakmax - $detaknormalatas) * 0.70) + $detaknormalatas) - ((($detakmax - $detaknormalatas) * 0.85) + $detaknormalatas);
            } elseif ($kategori == "empat") {

                $hasilkategori = "7 - 9 Tahun";

                $detaknormalbawah = "70";
                $detaknormalatas = "110";

                $detakmax = 220 - $usia;

                //SEDANG

                $sedangMin = ((($detakmax - $detaknormalbawah) * 0.50) + $detaknormalbawah) - ((($detakmax - $detaknormalbawah) * 0.69) + $detaknormalbawah);
                $sedangMax = ((($detakmax - $detaknormalatas) * 0.50) + $detaknormalatas) - ((($detakmax - $detaknormalatas) * 0.69) + $detaknormalatas);

                //BERAT

                $atasMin = ((($detakmax - $detaknormalbawah) * 0.70) + $detaknormalbawah) - ((($detakmax - $detaknormalbawah) * 0.85) + $detaknormalbawah);
                $atasMax = ((($detakmax - $detaknormalatas) * 0.70) + $detaknormalatas) - ((($detakmax - $detaknormalatas) * 0.85) + $detaknormalatas);
            } elseif ($kategori == "lima") {

                $hasilkategori = "10 Tahun Keatas";

                $detaknormalbawah = "60";
                $detaknormalatas = "100";

                $detakmax = 220 - $usia;


                //SEDANG

                $sedangMin = ((($detakmax - $detaknormalbawah) * 0.50) + $detaknormalbawah) - ((($detakmax - $detaknormalbawah) * 0.69) + $detaknormalbawah);
                $sedangMax = ((($detakmax - $detaknormalatas) * 0.50) + $detaknormalatas) - ((($detakmax - $detaknormalatas) * 0.69) + $detaknormalatas);

                //BERAT

                $atasMin = ((($detakmax - $detaknormalbawah) * 0.70) + $detaknormalbawah) - ((($detakmax - $detaknormalbawah) * 0.85) + $detaknormalbawah);
                $atasMax = ((($detakmax - $detaknormalatas) * 0.70) + $detaknormalatas) - ((($detakmax - $detaknormalatas) * 0.85) + $detaknormalatas);
            }
            $data = array(
                'max_sedang' => $sedangMax,
                'min_sedang' => $sedangMin,
                'max_atas' => $atasMax,
                'min_atas' => $atasMin,
                'kategori' => $hasilkategori,
                'kelamin' => $kelamin

            );


            return $data;
        }
    }

    public function diseaseDetect()
    {
        if (
            isset($_POST['submit']) && isset($_POST['demam']) && isset($_POST['nt'])
            && isset($_POST['bk']) && isset($_POST['hpp']) && isset($_POST['sn'])
            && isset($_POST['ruam']) && isset($_POST['tnn']) && isset($_POST['ttm'])
            && isset($_POST['nyar']) && isset($_POST['pkgb']) && isset($_POST['sk'])
            && isset($_POST['hm']) && isset($_POST['batuk']) && isset($_POST['no'])
            && isset($_POST['mm']) && isset($_POST['foto']) && isset($_POST['ns'])
            && isset($_POST['kk']) && isset($_POST['bbm']) && isset($_POST['tm'])
            && isset($_POST['nmb']) && isset($_POST['nkm']) && isset($_POST['bppatdr'])
            && isset($_POST['muntah']) && isset($_POST['diare']) && isset($_POST['rewel'])
            && isset($_POST['kejang'])
        ) {


            $demam      = $_POST['demam'];
            $nt         = $_POST['nt'];
            $bk         = $_POST['bk'];
            $hpp        = $_POST['hpp'];
            $sn         = $_POST['sn'];
            $ruam       = $_POST['ruam'];
            $tnn        = $_POST['tnn'];
            $ttm        = $_POST['ttm'];
            $nyar       = $_POST['nyar'];
            $pkgb       = $_POST['pkgb'];
            $sk         = $_POST['sk'];
            $hm         = $_POST['hm'];
            $batuk      = $_POST['batuk'];
            $no         = $_POST['no'];
            $mm         = $_POST['mm'];
            $foto       = $_POST['foto'];
            $ns         = $_POST['ns'];
            $kk         = $_POST['kk'];
            $bbm        = $_POST['bbm'];
            $tm         = $_POST['tm'];
            $nmb        = $_POST['nmb'];
            $nkm        = $_POST['nkm'];
            $bppatdr    = $_POST['bppatdr'];
            $muntah      = $_POST['muntah'];
            $diare      = $_POST['diare'];
            $rewel      = $_POST['rewel'];
            $kejang     = $_POST['kejang'];


            if ($demam == "dy" && $nt == "nty" && $hm == "hmy" && $batuk == "by" && $no == "noy" && $mm == "mmy" && $foto == "fotoy") {

                $keterangan = "Anda Mungkin Terkena Penyakit Campak";
                $hasil = "Campak";

                $pengobatan = [
                    "1. Minum banyak air untuk mencegah dehidrasi",
                    "2. Banyak istirahat dan hindari sinar matahari selama mata masih sensitif terhadap cahaya",
                    "3. Minum obat penurun demam dan obat pereda sakit serta nyeri"
                ];
            } elseif ($demam == "dy" && $ttm == "ttmy" && $pkgb == "pkgby" && $ns == "nsy" && $kk == "kky") {

                $keterangan = "Anda Mungkin Terkena Penyakit Campak Jerman";
                $hasil = "Campak Jerman";

                $pengobatan = [
                    "1. Minum banyak air untuk mencegah dehidrasi",
                    "2. Banyak istirahat Untuk mengurangi nyeri dan demam",
                    "3. Minum air hangat bercampur madu dan lemon untuk meredakan sakit tenggorokan dan pilek."
                ];
            } elseif (
                $demam == "dy" && $bk == "bky" && $tnn == "tnny" && $nt == "nty" && $sk == "sky" && $hpp == "hppy"
                && $sn == "sny" && $diare == "diarey"
            ) {

                $keterangan = "Anda Mungkin Terkena COVID (Corona)";
                $hasil = "COVID (Corona)";

                $pengobatan = [
                    "1. Beristirahat, minum banyak air, dan makan makanan bergizi.",
                    "2. Gunakan ruangan yang terpisah dari anggota keluarga Anda, dan jika memungkinkan gunakan kamar mandi khusus. Bersihkan dan lakukan disinfeksi pada permukaan benda yang sering disentuh.",
                    "3. Segera pergi ke rumah sakit untuk mendapatkan pengobatan"
                ];
            } elseif ($demam == "dy" && $muntah == "muntahy" && $diare == "diarey" && $rewel == "rewely" && $kejang == "kejangy") {

                $keterangan = "Anda Mungkin Terkena Penyakit Polio";
                $hasil = "Polio";

                $pengobatan = [
                    "1. Minum obat pereda nyeri untuk meredakan nyeri, sakit kepala, dan demam. Contoh obat ini adalah ibuprofen.",
                    "2. Minum obat antibiotik untuk mengobati infeksi bakteri yang bisa menyertai polio, misalnya infeksi saluran kemih. Contoh antibiotik yang bisa diberikan adalah ceftriaxone.",
                    "3. Minum obat pelemas otot (antispasmodik) untuk meredakan ketegangan pada otot. Contoh obat ini adalah tolterodine dan scopolamine. Selain pemberian obat, kompres hangat juga dapat digunakan untuk meredakan ketegangan otot."
                ];
            } elseif ($demam == "dy" && $nmb == "nmby" && $nkm == "nkmy" && $bppatdr == "bppatdry") {

                $keterangan = "Anda Mungkin Terkena Penyakit Gondongan";
                $hasil = "Gondongan";

                $pengobatan = [
                    "1. Memperbanyak istirahat dan mencukupkan tidur",
                    "2. Mengompres area yang bengkak dengan air hangat atau air dingin untuk meredakan rasa sakit.",
                    "3. Memperbanyak minum air putih dan mengonsumsi makanan lunak agar tidak perlu mengunyah terlalu banyak."
                ];
            } elseif ($demam == "dy" && $sk == "sky" && $bbm == "bbmy" && $tm == "tmy") {

                $keterangan = "Anda Mungkin Terkena Penyakit Cacar Air";
                $hasil = "Cacar Air";

                $pengobatan = [
                    "1. Banyak minum dan dan mengonsumsi makanan yang lembut dan tidak asin atau asam, terutama jika ruam cacar tedapat pada mulut.",
                    "2. Beristirahat cukup dan hindari kontak dengan orang lain untuk mencegah penyebaran cacar air.",
                    "3. Mandi dengan air hangat, 3-4 kali sehari, selama beberapa hari setelah timbulnya ruam. Setelah itu, keringkan dengan cara tepuk-tepuk dengan handuk hingga kering."
                ];
            } else {
                $keterangan = "Mohon Maaf Kami Belum Bisa Menganalisa Penyakit Yang Anda Rasakan.";
                $hasil = "Not Found";

                $pengobatan = "Silahkan hubungin dokter lebih lanjut";
            }

            $data = array(
                'penyakit' => $hasil,
                'keterangan' => $keterangan,
                'pengobatan' => $pengobatan
            );

            return $data;
        }
    }
}

class Information
{

    public function podcastAction($type)
    {
        if ($type == "Kesehatan Mental") {
            $title = "Senggang Bersama Podcast 13: Menjaga Kesehatan Mental";
            $source = "";
            $path = "../assets/audio/Senggang Bersama Podcast 13 Menjaga Kesehatan Mental.mp3";
        } elseif ($type == "Diabetes") {
            $title = "PODCAST SAPA SEHAT - MANIS BOLEH, DIABETES JANGAN! (HARI DIABETES SEDUNIA)";
            $source = "";
            $path = "../assets/audio/Senggang Bersama Podcast 2 Diabetes.mp3";
        } elseif ($type == "Jantung") {
            $path = "../assets/audio/Senggang Bersama Podcast 3 Jantung.mp3";
            $source = "";
        }

        $data = array(
            'name' => $title,
            'source' => $source,
            'path' => $path
        );

        return $data;
    }

    public function displayNews($category)
    {
        if ($category == 'covid') {
            $title = "Walau Konsumsi Suplemen Vitamin Saat Pandemi, Asupan Sayur dan Buah Tetap Penting";
            $writer = "Giovani Dio P (Liputan6.com)";
            $date = "September 15, 2020";
            $link = "https://www.liputan6.com/health/read/4355030/walau-konsumsi-suplemen-vitamin-saat-pandemi-asupan-sayur-dan-buah-tetap-penting";
            $content = "
                <p>Liputan6.com, Jakarta Konsumsi suplemen vitamin menjadi salah satu cara untuk meningkatkan imunitas tubuh di masa pandemi. Meski begitu, asupan sayur dan buah pun juga harus tetap tercukupi.</p>
                <p>Dokter spesialis gizi klinik Cut Hafiah dalam siaran dialog dari Graha BNPB, Jakarta beberapa waktu lalu mengatakan bahwa di masa pandemi, memang banyak orang yang membeli suplemen vitamin seperti vitamin C dan D.</p>
                <p>'Sebenarnya seperti vitamin C yang terserap dalam tubuh itu hanya 200 sampai 300 miligram, dari bahan makanan sumber pun jika kita makan 5 sampai 6 porsi sayur dan buah setiap hari, itu kandungan antioksidan dan kandungan vitamin C-nya cukup tinggi,' kata Hafiah, dikutip Minggu (13/9/2020).</p>
                <p>'Jadi jika ingin mengonsumsi (vitamin), konsumsilah dengan dosis minimal seperti 75 sampai 200 miligram,' tambahnya.</p>
                <p><h4>Makan Sayur dan Buah</h4>                
                <p>Menurut Hafiah, angka kecukupan vitamin C pada dewasa berkisar antara 75 hingga 95 miligram. Ia memberikan contoh, makan tiga buah kiwi sudah mampu memberikan seseorang 40 sampai 50 miligram vitamin.</p>
                <p>'Itu sudah hampir mencukupi, ditambah sayur dan buah lainnya sebenarnya itu sudah cukup, dan ditambah makan makanan sehat lainnya,' kata Hafiah.</p>
                <p>Apabila dikonsumsi secara berlebihan, vitamin yang berlebih dalam tubuh tidak akan terserap hingga akhirnya terbuang bersama urin.</p>
                <p>'Yang paling penting adalah selain mengonsumsi suplementasi, kita lengkapkan dulu asupan makanan sehat dan seimbang lalu boleh ditambahkan asupan vitamin C, vitamin D, ataupun omega 3 jika kita memang berinteraksi di luar atau tidak work from home.'</p>";
        } elseif ($category == 'psikologi') {
            $title = "bebas stress dengan 1 menit yoga tertawa";
            $writer = "tim CNN Indonesia";
            $date = "11 November 2020";
            $link = "https://www.cnnindonesia.com/gaya-hidup/20201111090009-255-568372/bebas-stres-dengan-1-menit-yoga-tertawa";
            $content = "<p>
            Jakarta, CNN Indonesia -- Yoga identik dengan aneka gerakan tubuh yang fleksibel dan sulit dilakukan. Namun pada kenyataannya, yoga tak melulu harus diikuti dengan aktivitas fisik seperti itu. Salah satu yang paling mudah dilakukan adalah yoga tertawa. Seperti namanya, yang harus Anda lakukan hanyalah tertawa.</p>
            <p>'Yoga tertawa kalo dilihat dari kitab yoga sutra patanjali adalah proses pembersihan dari tubuh kita melalui gelombang pikiran yang kita getarkan lewat tertawa kita melepas beban pikiran, melepas penat kita sehingga kita jadi plong. Dan ini akan menyehatkan kita. Tertawa bagian dari asana,' kata Eka Sukma Putra, Founder Eka Sukma Yoga Foundation kepada CNNIndonesia.com.</p>
            <p>Hanya saja Eka menyebut bahwa tertawa untuk yoga ini berbeda dengan tertawa sehari-hari. Dalam yoga tertawa ini, tertawa dilakukan dengan kesadaran penuh dan tak perlu alasan atau hal untuk untuk mulai tertawa.</p>
            <p>'Caranya? Tertawa dalam yoga itu harus lepaskan dulu dari obyek yang di luar diri. Kemudian lakukan getaran tertawa dari dalam pusatkan dengan diri sehingga kita selaras dan harmonis dalam tubuh yang menyeimbangkan semua hormon endokrin dan menyeimbangkan homeostasis dan saraf-saraf otonom,' ucapnya.</p>
            <p>'Tertawa itu getarannya melepaskan, membersihkan, senyum muncul dari kedamaian dari kebersihan jiwa senyum dari dalam, inner beauty dan tertawa outer beauty. Senyum itu rangkaian dari tertawa.'</p>
            <p>Idealnya, yoga tertawa ini dilakukan bersama dengan latihan napas, aktivitas tubuh, dan dilanjutkan dengan meditasi. Waktu yang dibutuhkan pun bervariasi antara 10-30 menit. Hanya saja, Anda juga bisa yoga tertawa dalam waktu singkat tanpa diikuti dengan meditasi.</p>
            <p>Untuk menghilangkan stres, yoga tertawa ini bisa dilakukan setiap saat. Termasuk saat Anda tengah merasa jenuh dan penat saat bekerja di depan laptop. Anda hanya perlu menyisihkan waktu setidaknya satu menit untuk tertawa.</p>
            <p>'Buka jendela lalu memandang yang jauh. Setelah itu pejamkan mata dan mulailah tertawa. Sadari tawa itu dan rasakan getaran tertawa di seluruh tubuh Anda,' kata pria yang juga menjadi resident yoga guru di Amankila Resort, Manggis, Bali ini.</p>
            <p>'Yang penting pusatkan pikiran, mindful agar manfaatnya lebih terasa. Tanpa mindful, tertawa hanya akan sementara saja. Misalnya saat Anda nonton komedi atau bercanda dengan kawan, itu sementara saja.'</p>
            <p>Ada berbagai manfaat yang didapat dari yoga tertawa, misalnya untuk menjaga kesehatan tubuh, mendamaikan diri, menghilangkan stres serta depresi, sampai menjaga keseimbangan emosi.</p>
            <p><h4>Sejarah Yoga Tertawa</h4></p>
            <p>Yoga Tertawa dipopulerkan oleh dokter keluarga Madan Kataria yang memodernisasi dan menyederhanakan yoga tertawa di masa awalnya. Mengutip berbagai sumber, Sesi yoga tawa dapat dimulai dengan teknik pemanasan lembut yang meliputi peregangan, nyanyian, tepuk tangan, kontak mata dan gerakan tubuh, untuk membantu memecah hambatan dan mendorong rasa bermain. Latihan pernapasan digunakan untuk mempersiapkan paru-paru untuk tertawa, diikuti dengan serangkaian 'latihan tertawa' yang menggabungkan metode akting dan teknik visualisasi dengan main-main.</p>
            <p>Latihan tertawa diselingi dengan latihan pernapasan. Tertawa selama dua puluh menit sudah cukup untuk mengembangkan manfaat fisiologis sepenuhnya.</p>
            <p>'Ini baik dilakukan saat ini, karena di masa sekarang ini orang kurang banyak tertawa, tapi stres. Maka tertawa saja, ini bagian dari proses penerimaan diri, bukan penolakan. Semakin banyak menolak hal-hal yang terjadi saat ini, maka semakin stres.'</p>";
        } elseif ($category == 'gizi') {
            $title = "Bakal Sakit Kalau Tidak Pernah Sarapan? Belum Tentu, Ini Penjelasannya";
            $writer = "Kanya Anindita-detikHealth";
            $date = "November 16, 2020";
            $link = "https://health.detik.com/diet/d-5256540/bakal-sakit-kalau-tidak-pernah-sarapan-belum-tentu-ini-penjelasannya?_ga=2.22569661.706203095.1606270993-1283701415.1606270993";
            $content = "
            <p>Jakarta - Sarapan dianggap penting karena dapat menyehatkan tubuh. Beberapa ahli nutrisi merekomendasikan agar tidak melewatkan sarapan karena dapat mencegah obesitas. Orang yang suka sarapan cenderung memiliki bentuk tubuh yang bagus karena terbiasa dengan pola hidup sehat.</p>
            <p>Dikutip dari Insider, tidak sarapan dapat menaikkan berat badan. Orang yang melewatkan sarapan akan mudah lapar dan makan lebih banyak saat makan siang. Porsi berlebihan dapat meningkatkan jumlah kalori yang mengakibatkan kegemukan.</p>
            <p>Di samping efek negatif tentang hal tersebut, ada beberapa fakta menarik yang perlu diketahui apabila tidak sarapan. Setiap orang memiliki kebiasaan yang berbeda-beda, ada yang tetap sehat walaupun tidak sarapan, ada juga yang merasa lemas jika melewatkan sarapan. </p>
            <p>Perlu diketahui, sarapan teratur tidak menjamin meningkatnya metabolisme tubuh. Walaupun kita mengonsumsi makanan sehat saat sarapan, namun dalam porsi yang banyak serta tidak disertai olahraga yang cukup, kalori akan terus bertambah.</p>
            <p>Selain itu, sarapan bersifat 'opsional'. Jika merasa lapar di pagi hari, silakan sarapan dengan porsi yang cukup serta menu makanan yang sehat. Jika merasa tidak lapar di pagi hari, silakan makan saat jam makan siang atau diselingi cemilan sebelumnya.</p>
            <p>Tidak ada penelitian yang pasti mengenai efek buruk dari melewatkan sarapan. Pada dasarnya, setiap orang memiliki tingkat kekebalan tubuh yang berbeda-beda. Hal itu tidak bisa diukur dengan rajin atau tidaknya sarapan, melainkan disertai dengan pola hidup sehat yang lainnya.</p>
            <p>Konsultasikan dengan dokter dan ahli gizi untuk lebih mengenal kebutuhan nutrisi secara lebih detail.</p>";
        } elseif ($category == 'penyakit') {
            $title = "5 Penyakit Ini Bisa Dideteksi Lewat Kondisi Tangan";
            $writer = "Teddy Tri S.B (Liputan6.com)";
            $date = "October 27, 2020";
            $link = "https://www.liputan6.com/global/read/4393363/5-penyakit-ini-bisa-dideteksi-lewat-kondisi-tangan";
            $content = "<p>
            Liputan6.com, Jakarta - Rupanya, tangan adalah bagian tubuh yang dapat menunjukkan kondisi seseorang, apakah sehat atau sakit. Meski terlihat sederhana, tangan dapat merefleksikan kesehatan manusia.</p>
            <p>Salah satu cara mengidentifikasi penyakit adalah dengan membedakan perubahan warna, gerakan hingga kondisi fisik tangan.</p>
            <p>Beda warna, kondisi dan gerakan maka akan beda pula jenis gejala yang dialami oleh seseorang. Dengan cara seperti ini Anda bisa mencegah datangnya penyakit lebih cepat dari sebelumnya.</p>
            <p>Seperti dikutip dari laman Health.com, Selasa (27/10/2020), berikut 5 penyakit yang bisa diketahui lewat kondisi tangan:</p>
            <p><h4>1. Genggaman Tangan Melemah</h4></p>
            <p>Dalam dunia bisnis, jabatan tangan yang lemah dikaitkan dengan kepribadian seseorang. Namun, dalam dunia kedokteran, ini bisa menjadi masalah kesehatan Anda.</p>
            <p>'Selama pemeriksaan fisik untuk pasien, kami benar-benar memerhatikan genggaman pasien,' ujar Anne Albers, seorang ahli jantung.</p>
            <p>Menurut ulasan pada 2016 di International Journal of Cardiology, kekuatan cengkeraman yang menurun ditambah dengan gaya berjalan lambat, menandakan adanya risiko kematian yang lebih tinggi dari penyakit jantung.</p>
            <p><h4>2. Benjolan Merah Serta Lecet</h4></p>
            <p>Ruam merah di tangan atau pergelangan yang seketika melepuh atau berdarah diindikasikan bahwa Anda mengalami alergi nikel.</p>
            <p>Kepekaan terhadap nikel adalah salah satu penyebab paling umum dermatitis kontak alergi, menurut American Academy of Dermatology.</p>
            <p>Banyak benda yang menyentuh kulit Anda mengandung nikel: gelang, jam tangan, cincin, bahkan telepon seluler.</p>
            <p><h4>3. Perubahan Warna Jari</h4></p>
            <p>Jika jari Anda pucat (berarti Anda kekurangan darah) dan apabila biru (atau ungu atau hitam) ketika dingin atau Anda sedang stres.</p>
            <p>Perubahan suhu atau keadaan emosi yang tiba-tiba dapat memicu kondisi ini, yang menyebabkan hilangnya aliran darah ke jari atau jari kaki secara sementara.</p>
            <p><h4>4. Tremor Tangan</h4></p>
            <p>Terkadang guncangan tangan bukan masalah besar, dan di lain waktu itu bisa menjadi tanda penyakit neurologis.</p>
            <p>Setiap orang memiliki sedikit guncangan di tangan mereka. Ini disebut tremor fisiologis, Dr. Barrett menjelaskan, dan ketika Anda kurang tidur, terlalu banyak minum kopi, mengonsumsi obat-obatan tertentu, hingga konsumsi alkohol berlebih akan menyebabkan itu terjadi.</p>
            <p><h4>5. Nyeri Tangan, Kaku dan Bengkak</h4></p>
            <p>Seseorang yang mengalami nyeri, kaku dan bengkak pada tangan dapat diindentifikasikan sebagai ciri sejumlah penyakit.</p>
            <p>Sejumlah penyakit itu adalah rheumatoid arthritis, psoriatic arthritis, lupus, vasculitis (radang pembuluh darah), scleroderma (penyakit jaringan ikat), dan dermatomiositis (penyakit kulit dan otot).</p>
            <p>Tangan bengkak juga menjadi ciri-ciri bahwa seseorang mengalami radang usus,' kata Dr. Weselman.</p>
            <p>'Biasanya akan juga ditemukan di bagian lutut dan pergelangan kaki,' katanya.
            </p>";
        }

        $data = array(
            'title' => $title,
            'writer' => $writer,
            'date' => $date,
            'link' => $link,
            'content' => $content
        );

        return $data;
    }
}

class Implementationmachinelearning
{

    public function detectSentiment($text)
    {

        $positiveWords = array_map('str_getcsv', file('kamus_positif.csv'));
        $positiveWords = array_column($positiveWords, 0);

        $negativeWords = array_map('str_getcsv', file('kamus_negatif.csv'));
        $negativeWords = array_column($negativeWords, 0);

        $positiveCount = count(array_intersect($positiveWords, explode(' ', $text)));
        $negativeCount = count(array_intersect($negativeWords, explode(' ', $text)));

        if ($positiveCount > $negativeCount) {
            return 'positive';
        } elseif ($positiveCount < $negativeCount) {
            return 'negative';
        } else {
            return 'neutral';
        }
    }
    //nilai grafik suhu 

    function nilai_grafiksuhu($suhu)
    {
        if (suhu_rendah($suhu) != 0) {
            echo "Rendah (" . suhu_rendah($suhu) . ")";
            echo "<br>";
        }
        if (suhu_normal($suhu) != 0) {
            echo "Normal (" . suhu_normal($suhu) . ")";
            echo "<br>";
        }
        if (suhu_maksimal($suhu) != 0) {
            echo "Tinggi (" . suhu_maksimal($suhu) . ")";
            echo "<br>";
        }
        echo "<br>";
    }

    //nilai grafik air
    function nilai_grafikair($air)
    {
        if (air_sedikit($air) != 0) {
            echo "Sedikit (" . air_sedikit($air) . ")";
            echo "<br>";
        }
        if (air_normal($air) != 0) {
            echo "Normal (" . air_normal($air) . ")";
            echo "<br>";
        }
        if (air_banyak($air) != 0) {
            echo "Banyak (" . air_banyak($air) . ")";
            echo "<br>";
        }
        echo "<br>";
    }

    //nilai grafik waktu

    function nilai_grafikwaktu($waktu)
    {
        if (waktu_cepat($waktu) != 0) {
            echo "Cepat (" . waktu_cepat($waktu) . ")";
            echo "<br>";
        }
        if (waktu_sedang($waktu) != 0) {
            echo "Sedang (" . waktu_sedang($waktu) . ")";
            echo "<br>";
        }
        if (waktu_lambat($waktu) != 0) {
            echo "Lambat (" . waktu_lambat($waktu) . ")";
            echo "<br>";
        }
        echo "<br>";
    }

    //nilai grafik beras

    function nilai_grafikberas($beras)
    {
        if (beras_sedikit($beras) != 0) {
            echo "Sedikit (" . beras_sedikit($beras) . ")";
            echo "<br>";
        }
        if (beras_sedang($beras) != 0) {
            echo "Sedang (" . beras_sedang($beras) . ")";
            echo "<br>";
        }
        if (beras_banyak($beras) != 0) {
            echo "Banyak (" . beras_banyak($beras) . ")";
            echo "<br>";
        }
        echo "<br>";
    }

    //Hasil Fuzzifikasi

    function hasilFuzzifikasi($suhu, $air, $beras, $waktu)
    {

        nilai_grafiksuhu($suhu);
        nilai_grafikair($air);
        nilai_grafikberas($beras);
        nilai_grafikwaktu($waktu);
    }

    //INFERENSI

    function inferensi($suhu, $air, $beras, $waktu)
    {

        $x = 0;
        $no = 1;
        $kondisi = [];

        $kondisi_suhu_print = ["Rendah", "Normal", "Tinggi"];
        $kondisi_waktu_print = ["Cepat", "Sedang", "Lambat"];
        $kondisi_beras_print = ["Sedikit", "Sedang", "Banyak"];
        $kondisi_air_print = ["Sedikit", "Normal", "Banyak"];

        $nilaisuhu = [suhuRendah($suhu), suhuNormal($suhu), suhuMaksimal($suhu)];
        $nilaiwaktu = [waktuCepat($waktu), waktuSedang($waktu), waktuLambat($waktu)];
        $nilaiberas = [berasSedikit($beras), berasSedang($beras), berasBanyak($beras)];
        $nilaiair = [airSedikit($air), airNormal($air), airBanyak($air)];

    

        //i = suhu 
        //j = waktu
        //k = beras
        //l = air

        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                for ($k = 0; $k < 3; $k++) {
                    for ($l = 0; $l < 3; $l++) {
                        if (($nilaisuhu[$i] > 0) && ($nilaiwaktu[$j] > 0) && ($nilaiberas[$k] > 0) && ($nilaiair[$l] > 0)) {

                            $minimal[$x] = min($nilaisuhu[$i], $nilaiwaktu[$j], $nilaiberas[$k], $nilaiair[$l]);

                            //SUHU NORMAL PULEN

                            //suhu normal; air normal; beras sedikit & sedang; waktu sedang&lambat
                            if (($i == 1) && ($j > 0) && ($k <= 1) && ($l == 1)) {
                                $kondisi[$x] = "Pulen";
                            }
                            //suhu normal; air banyak; beras sedikit; waktu sedang
                            else if (($i == 1) && ($j == 1) && ($k == 0) && ($l == 2)) {
                                $kondisi[$x] = "Pulen";
                            }
                            //suhu normal; air banyak; beras sedang; waktu sedang&lambat
                            else if (($i == 1) && ($j > 0) && ($k == 1) && ($l == 2)) {
                                $kondisi[$x] = "Pulen";
                            }
                            //suhu normal; air banyak; beras banyak; waktu lambat
                            else if (($i == 1) && ($j == 2) && ($k == 2) && ($l == 2)) {
                                $kondisi[$x] = "Pulen";
                            }

                            //SUHU TINGGI PULEN

                            //suhu tinggi; air normal; beras sedikit; waktu cepat&sedang&lambat
                            else if (($i == 2) && ($j >= 0) && ($k == 0) && ($l == 1)) {
                                $kondisi[$x] = "Pulen";
                            }
                            //suhu tinggi; air banyak; beras sedang; waktu cepat&sedang&lambat
                            else if (($i == 2) && ($j >= 0) && ($k == 1) && ($l == 2)) {
                                $kondisi[$x] = "Pulen";
                            }
                            //suhu tinggi; air banyak; beras banyak; waktu sedang&lambat
                            else if (($i == 2) && ($j > 0) && ($k == 2) && ($l == 2)) {
                                $kondisi[$x] = "Pulen";
                            }

                            //KASUS BUBUR

                            //suhu normal; air banyak; beras sedikit; waktu lambat
                            else if (($i == 1) && ($j == 2) && ($k == 0)  && ($l == 2)) {
                                $kondisi[$x] = "Bubur";
                            } else if (($i == 2) && ($j >= 0) && ($k == 0)  && ($l == 2)) {
                                $kondisi[$x] = "Bubur";
                            } else {
                                $kondisi[$x] = "Tidak Matang";
                            }

                            echo "<font color='#ffffff'><p>" . "IF Suhu " . $kondisi_suhu_print[$i] . " = " . $nilaisuhu[$i] . " AND Waktu " . $kondisi_waktu_print[$j] . " = " . $nilaiwaktu[$j] . " AND Beras " . $kondisi_beras_print[$k] . " = " . $nilaiberas[$k] . " AND Air " . $kondisi_air_print[$l] . " = " . $nilaiair[$l] . " THEN Hasil Nasi = " . $kondisi[$x] . " (" . $minimal[$x] . ")</font></p><br>";
                            echo "<font color='#ffffff'><p>" . "------------------------------------------------------------------------------------------------------------------------</font></p><br>";
                            $x++;
                        }
                        $no++;
                        //echo"<font color='#ffffff'>$no<br>";

                    }
                }
            }
        }

        //NILAI FUZZY OUPUT

        $nilai_tidakmatang = 0;
        $nilai_pulen = 0;
        $nilai_bubur = 0;

        for ($m = 0; $m < $x; $m++) {
            if ($kondisi[$m] == "Bubur") {
                $nilai_bubur = max($minimal[$m], $nilai_bubur);
            } else if ($kondisi[$m] == "Pulen") {
                $nilai_pulen = max($minimal[$m], $nilai_pulen);
            } else {
                $nilai_tidakmatang = max($minimal[$m], $nilai_tidakmatang);
            }
        }

        //DEFUZZIFIKASI

        //$nilai_y = ( ((5+10+15+20)*$nilai_tidakmatang) + ((35+38+41+44+47+50+53+56+59+62+65)*$nilai_pulen) + ((70+80+90+100)*$nilai_bubur) )/( (4*$nilai_tidakmatang) + (6*$nilai_pulen) + (4*$nilai_bubur) );

        echo "<br><br><u><font color='#ffffff'><h3>" . "Hasil Inferensi" . "</font></h3></u><br><br>";
        echo "<font color='#ffffff'><p>" . "Nilai Tidak Matang \t= " . $nilai_tidakmatang . "</font></p>";
        echo "<font color='#ffffff'><p>" . "Nilai Pulen \t= " . $nilai_pulen . "</font></p>";
        echo "<font color='#ffffff'><p>" . "Nilai Bubur \t= " . $nilai_bubur . "</font></p><br><br>";


        echo "<u><font color='#ffffff'><h3>" . "Hasil Defuzzifikasi" . "</font></h3></u><br><br>";

        echo '<img src="/TUBES_AI/grafik_hasilberas.jpg"><br><br><br><br>';

        //TIDAK MATANG
        if (($nilai_tidakmatang != 0) && ($nilai_pulen == 0) && ($nilai_bubur == 0)) {
            echo '<img src="https://latex.codecogs.com/svg.latex?{\color{White}y*&space;=&space;\frac{((2&plus;4&plus;6&plus;8&plus;10&plus;12&plus;14&plus;16&plus;18&plus;20))*' . $nilai_tidakmatang . ')&plus;0&plus;0}{(10*' . $nilai_tidakmatang . ')&plus;0&plus;0}"/>';
            $nilai_y = ((2 + 4 + 6 + 8 + 10 + 12 + 14 + 16 + 18 + 20) * $nilai_tidakmatang) / (10 * $nilai_tidakmatang);
        }
        //HANYA BUBUR
        else if (($nilai_tidakmatang == 0) && ($nilai_pulen == 0) && ($nilai_bubur != 0)) {
            echo '<img src="https://latex.codecogs.com/svg.latex?{\color{White}y*&space;=&space;\frac{0&plus;0&plus;((80&plus;82&plus;84&plus;86&plus;88&plus;90&plus;92&plus;94&plus;96&plus;98)*' . $nilai_bubur . ')}{0&plus;0&plus;(10*' . $nilai_bubur . ')}"/>';
            $nilai_y = ((80 + 82 + 84 + 86 + 88 + 90 + 92 + 94 + 96 + 98) * $nilai_bubur) / (10 * $nilai_bubur);
        }
        //HANYA PULEN
        else if (($nilai_tidakmatang == 0) && ($nilai_pulen != 0) && ($nilai_bubur == 0)) {
            echo '<img src="https://latex.codecogs.com/svg.latex?{\color{White}y*&space;=&space;\frac{0&plus;((40&plus;42&plus;44&plus;46&plus;48&plus;50&plus;52&plus;54&plus;58&plus;60)*' . $nilai_pulen . ')&plus;0}{(10*' . $nilai_pulen . ')&plus;0&plus;0}"/>';
            $nilai_y = ((40 + 42 + 44 + 46 + 48 + 50 + 52 + 54 + 58 + 60) * $nilai_pulen) / ((10 * $nilai_pulen));
        }
        // TIDAK MATANG DAN PULEN
        else if (($nilai_tidakmatang != 0) && ($nilai_pulen != 0) && ($nilai_bubur == 0)) {
            echo '<img src="https://latex.codecogs.com/svg.latex?{\color{White}y*&space;=&space;\frac{((4&plus;8&plus;12&plus;16&plus;20))*' . $nilai_tidakmatang . ')&plus;((35&plus;40&plus;45&plus;50&plus;55&plus;60)*' . $nilai_pulen . ')&plus;0}{(5*' . $nilai_tidakmatang . ')&plus;(5*' . $nilai_pulen . ')&plus;0}"/>';
            $nilai_y = (((4 + 8 + 12 + 16 + 20) * $nilai_tidakmatang) + ((44 + 48 + 52 + 56 + 60) * $nilai_pulen)) / ((5 * $nilai_tidakmatang) + (5 * $nilai_pulen));
        }
        //PULEN DAN BUBUR
        else if (($nilai_tidakmatang == 0) && ($nilai_pulen != 0) && ($nilai_bubur != 0)) {
            echo '<img src="https://latex.codecogs.com/svg.latex?{\color{White}y*&space;=&space;\frac{0&plus;((44&plus;48&plus;52&plus;56&plus;60)*' . $nilai_pulen . ')&plus;((84&plus;88&plus;92&plus;96&plus;100)*' . $nilai_bubur . ')}{0&plus;(5*' . $nilai_pulen . ')&plus;(5*' . $nilai_bubur . ')}"/>';
            $nilai_y = (((44 + 48 + 52 + 56 + 60) * $nilai_pulen) + ((84 + 88 + 92 + 96 + 100) * $nilai_bubur)) / ((5 * $nilai_pulen) + (5 * $nilai_bubur));
        }

        echo "<br></br><br></br>";

        echo "<font color='#ffffff'><h3>" . "Tingkat Kematangan Nasi (y*) = " . round($nilai_y, 2) . "</font></h3><br><br>";
    }


    // SUHU

    function suhuRendah($suhu)
    {

        $nilai_suhurendah = 0;

        if ($suhu <= 60) {
            $nilai_suhurendah = 1;
        } else {
            if ($suhu > 60 && $suhu < 70) {
                $nilai_suhurendah = (70 - $suhu) / 10;
            } else {
                $nilai_suhurendah = 0;
            }
        }


        return $nilai_suhurendah;
    }

    function suhuNormal($suhu)
    {

        $nilai_suhunormal = 0;

        if ($suhu >= 60 && $suhu < 110) {
            if ($suhu >= 90 && $suhu <= 100) {
                $nilai_suhunormal = 1;
            } else {
                if ($suhu >= 60 && $suhu < 90) {
                    $nilai_suhunormal = ($suhu - 60) / 30;
                } else {
                    if ($suhu > 100 && $suhu <= 110) {
                        $nilai_suhunormal = (110 - $suhu) / 10;
                    } else {
                        $nilai_suhunormal = 0;
                    }
                }
            }
        }

        return $nilai_suhunormal;
    }

    function suhuMaksimal($suhu)
    {

        $nilai_suhumaksimal = 0;

        if ($suhu >= 100 && $suhu < 125) {
            if ($suhu >= 110 && $suhu <= 120) {
                $nilai_suhumaksimal = 1;
            } else {
                if ($suhu >= 100 && $suhu < 110) {
                    $nilai_suhumaksimal = ($suhu - 100) / (110 - 100);
                } else {
                    if ($suhu > 120 && $suhu <= 125) {
                        $nilai_suhumaksimal = (125 - $suhu) / (125 - 120);
                    } else {
                        $nilai_suhumaksimal = 0;
                    }
                }
            }
        }

        return $nilai_suhumaksimal;
    }


    //AIR


    function airSedikit($air)
    {

        $nilai_airsedikit = 0;

        if ($air <= 400) {
            $nilai_airsedikit = 1;
        } else {
            if ($air > 400 && $air < 600) {
                $nilai_airsedikit = (600 - $air) / 200;
            } else {
                $nilai_airsedikit = 0;
            }
        }

        return $nilai_airsedikit;
    }

    function airNormal($air)
    {

        $nilai_airnormal = 0;

        if ($air >= 400 && $air < 1000) {
            if ($air >= 600 && $air <= 800) {
                $nilai_airnormal = 1;
            } else {
                if ($air >= 400 && $air < 600) {
                    $nilai_airnormal = ($air - 400) / 200;
                } else {
                    if ($air > 800 && $air <= 1000) {
                        $nilai_airnormal = (1000 - $air) / 200;
                    } else {
                        $nilai_airnormal = 0;
                    }
                }
            }
        }

        return $nilai_airnormal;
    }

    function airBanyak($air)
    {

        $nilai_airbanyak = 0;

        if ($air >= 1000) {
            $nilai_airbanyak = 1;
        } else {
            if ($air >= 800 && $air < 1000) {
                $nilai_airbanyak = ($air - 800) / 200;
            } else {
                $nilai_airbanyak = 0;
            }
        }

        return $nilai_airbanyak;
    }

    //BERAS


    function berasSedikit($beras)
    {

        $nilai_berassedikit = 0;

        if ($beras <= 320) {
            $nilai_berassedikit = 1;
        } else {
            if ($beras > 320 && $beras < 480) {
                $nilai_berassedikit = (480 - $beras) / (480 - 320);
            } else {
                $nilai_berassedikit = 0;
            }
        }

        return $nilai_berassedikit;
    }

    function berasSedang($beras)
    {

        $nilai_berassedang = 0;

        if ($beras >= 320 && $beras < 800) {
            if ($beras >= 480 && $beras <= 640) {
                $nilai_berassedang = 1;
            } else {
                if ($beras >= 320 && $beras < 480) {
                    $nilai_berassedang = ($beras - 320) / (480 - 320);
                } else {
                    if ($beras > 640 && $beras <= 800) {
                        $nilai_berassedang = (800 - $beras) / (800 - 640);
                    } else {
                        $nilai_berassedang = 0;
                    }
                }
            }
        }

        return $nilai_berassedang;
    }

    function berasBanyak($beras)
    {

        $nilai_berasbanyak = 0;

        if ($beras >= 800) {
            $nilai_berasbanyak = 1;
        } else {
            if ($beras >= 640 && $beras < 800) {
                $nilai_berasbanyak = ($beras - 640) / (800 - 640);
            } else {
                $nilai_berasbanyak = 0;
            }
        }

        return $nilai_berasbanyak;
    }

    //WAKTU

    function waktuCepat($waktu)
    {

        $nilai_waktucepat = 0;

        if ($waktu <= 15) {
            $nilai_waktucepat = 1;
        } else {
            if ($waktu > 15 && $waktu < 25) {
                $nilai_waktucepat = (25 - $waktu) / 10;
            } else {
                $nilai_waktucepat = 0;
            }
        }

        return $nilai_waktucepat;
    }

    function waktuSedang($waktu)
    {

        $nilai_waktusedang = 0;

        if ($waktu >= 20 && $waktu < 35) {
            if ($waktu == 30) {
                $nilai_waktusedang = 1;
            } else {
                if ($waktu >= 20 && $waktu < 30) {
                    $nilai_waktusedang = ($waktu - 20) / 10;
                } else {
                    if ($waktu > 30 && $waktu <= 35) {
                        $nilai_waktusedang = (35 - $waktu) / 5;
                    } else {
                        $nilai_waktusedang = 0;
                    }
                }
            }
        }

        return $nilai_waktusedang;
    }

    function waktuLambat($waktu)
    {

        $nilai_waktulambat = 0;

        if ($waktu >= 40) {
            $nilai_waktulambat = 1;
        } else {
            if ($waktu > 30 && $waktu < 40) {
                $nilai_waktulambat = ($waktu - 30) / (40 - 30);
            } else {
                $nilai_waktulambat = 0;
            }
        }

        return $nilai_waktulambat;
    }
}


class Mathsubject
{

    //KONVERSI SATUAN

    public function radianToDegree($radian)
    {
        $hasil = $radian * (180 / pi());
        return $hasil;
    }

    public function degreeToRadian($degree)
    {
        $hasil = $degree * (pi() / 180);
        return $hasil;
    }

    public function celsiusToFahrenheit($celsius)
    {
        $hasil = ($celsius * 9 / 5) + 32;
        return $hasil;
    }

    public function fahrenheitToCelsius($fahrenheit)
    {
        $hasil = ($fahrenheit - 32) * 5 / 9;
        return $hasil;
    }

    public function decimalToBinary($decimal)
    {
        $hasil = decbin($decimal);
        return $hasil;
    }

    public function binaryToDecimal($binary)
    {
        $hasil = bindec($binary);
        return $hasil;
    }

    //BANGUN RUANG

    public function volumeKubus($sisi)
    {
        $hasil = pow($sisi, 3);
        return $hasil;
    }

    public function volumeBalok($panjang, $lebar, $tinggi)
    {
        $hasil = $panjang * $lebar * $tinggi;
        return $hasil;
    }
    public function volumeSilinder($jariJari, $tinggi)
    {
        $hasil = pi() * pow($jariJari, 2) * $tinggi;
        return $hasil;
    }
    public function volumeKerucut($jariJari, $tinggi)
    {
        $hasil = (1 / 3) * pi() * pow($jariJari, 2) * $tinggi;
        return $hasil;
    }

    //BANGUN DATAR

    public function luasPersegi($sisi)
    {
        $hasil = pow($sisi, 2);
        return $hasil;
    }
    public function luasPersegiPanjang($panjang, $lebar)
    {
        $hasil = $panjang * $lebar;
        return $hasil;
    }
    public function luasSegitiga($alas, $tinggi)
    {
        $hasil = (1 / 2) * $alas * $tinggi;
        return $hasil;
    }
    public function luasLingkaran($jariJari)
    {
        $hasil = pi() * pow($jariJari, 2);
        return $hasil;
    }
    public function convertDistance($value, $fromUnit, $toUnit)
    {
        $units = array(
            'mm' => 0.001,
            'cm' => 0.01,
            'm' => 1,
            'km' => 1000,
            'in' => 0.0254,
            'ft' => 0.3048,
            'yd' => 0.9144,
            'mi' => 1609.34,
        );

        if (!isset($units[$fromUnit]) || !isset($units[$toUnit])) {
            return "Unit tidak valid";
        }

        $hasil = $value * ($units[$fromUnit] / $units[$toUnit]);
        return $hasil;
    }

    function convertWeight($value, $fromUnit, $toUnit)
    {
        // Daftar faktor konversi berat dari satuan ke gram
        $conversionFactors = [
            'gram'       => 1,
            'kilogram'   => 1000,
            'pound'      => 453.592,
            'ounce'      => 28.3495,
            // tambahkan satuan berat lainnya beserta faktor konversinya jika diperlukan
        ];

        // Memastikan satuan yang diberikan valid
        $fromUnit = strtolower($fromUnit);
        $toUnit = strtolower($toUnit);

        if (!isset($conversionFactors[$fromUnit]) || !isset($conversionFactors[$toUnit])) {
            throw new Exception('Satuan berat yang diberikan tidak valid.');
        }

        // Konversi nilai ke gram terlebih dahulu
        $valueInGrams = $value * $conversionFactors[$fromUnit];

        // Konversi nilai dari gram ke satuan yang diinginkan
        $convertedValue = $valueInGrams / $conversionFactors[$toUnit];

        return $convertedValue;
    }
}

class Calculator
{

    public function add($numbers)
    {
        $hasil = array_sum($numbers);
        return $hasil;
    }

    public function subtract($numbers)
    {
        $result = array_shift($numbers);
        foreach ($numbers as $number) {
            $result -= $number;
        }
        $hasil = $result;
        return $hasil;
    }

    public function multiply($numbers)
    {
        $result = 1;
        foreach ($numbers as $number) {
            $result *= $number;
        }
        $hasil = $result;
        return $hasil;
    }

    public function divide($numbers)
    {
        $result = array_shift($numbers);
        foreach ($numbers as $number) {
            if ($number == 0) {
                $hasil = "Error: Division by zero!";
            }
            $result /= $number;
        }
        $hasil = $result;
        return $hasil;
    }

    public function sinDegrees($angle)
    {
        $hasil = sin(deg2rad($angle));
        return $hasil;
    }


    public function cosDegrees($angle)
    {
        $hasil = cos(deg2rad($angle));
        return $hasil;
    }

    // Fungsi Tangen
    public function tanDegrees($angle)
    {
        $hasil = tan(deg2rad($angle));
        return $hasil;
    }
}

class Physicsubject
{

    public function hitungKecepatan($jarak, $waktu)
    {
        $hasil = $jarak / $waktu;
        return $hasil;
    }
    public function hitungPercepatan($perubahanKecepatan, $waktu)
    {
        $hasil = $perubahanKecepatan / $waktu;
        return $hasil;
    }
    public function hitungUsaha($gayaberat, $jarak)
    {
        $hasil = $gayaberat * $jarak;
        return $hasil;
    }
    public function hitungEnergiKinetik($massa, $kecepatan)
    {
        $hasil = (1 / 2) * $massa * pow($kecepatan, 2);
        return $hasil;
    }
    public function hitungGayaGravitasi($massa1, $massa2, $jarak)
    {
        $konstantaGravitasi = 6.674 * pow(10, -11);
        $hasil = $konstantaGravitasi * ($massa1 * $massa2) / pow($jarak, 2);
        return $hasil;
    }
    public function hitungHukumNewton($massa, $percepatan)
    {
        $hasil = $massa * $percepatan;
        return $hasil;
    }
    public function hitungHukumOhm($tegangan, $hambatan)
    {
        $hasil = $tegangan / $hambatan;
        return $hasil;
    }
}

class User
{

    public function profileUser()
    {
        $usernamesesi = $_SESSION['username'];

        $database_user = new Database("task_gojek");

        $table = "users";


        $data = $database_user->innerJoin($table, "customers", "users.user_id = customers.user_id");
        if (empty($data)) {
            echo "Data tidak ditemukan";
        }

        return $data[0];
    }
}
