<?php
require_once '../config/koneksi.php';

$wisata = $_GET['wisata'] ?? '';
$rating = $_GET['rating'] ?? 'semua';

$query_str = "SELECT * FROM ulasan WHERE nama_wisata = '$wisata'";
if($rating != 'semua') {
    $query_str .= " AND rating = '$rating'";
}
$query_str .= " ORDER BY tanggal DESC";

$exec = mysqli_query($koneksi, $query_str);

if(mysqli_num_rows($exec) > 0) {
    while($row = mysqli_fetch_assoc($exec)) {
        ?>
        <div class="flex items-start gap-6 border-b border-slate-50 pb-8 last:border-0">
            <div class="w-12 h-12 rounded-full bg-slate-200 flex items-center justify-center font-bold text-slate-500 shrink-0 uppercase">
                <?= substr($row['nama_user'], 0, 1) ?>
            </div>
            <div class="flex-1">
                <h5 class="font-bold text-sky-950 mb-1"><?= htmlspecialchars($row['nama_user']) ?></h5>
                <div class="text-orange-400 text-[10px] mb-2 flex gap-1">
                    <?php for($i=1; $i<=5; $i++) echo ($i <= $row['rating']) ? '<i class="bi bi-star-fill"></i>' : '<i class="bi bi-star"></i>'; ?>
                </div>
                <p class="text-slate-600 text-sm leading-relaxed"><?= htmlspecialchars($row['komentar']) ?></p>
                <p class="text-[10px] text-slate-400 mt-4 font-bold tracking-widest uppercase">
                    <?= date('d M Y', strtotime($row['tanggal'])) ?>
                </p>
            </div>
        </div>
        <?php
    }
} else {
    echo "<div class='text-center py-10 text-slate-400 italic'>Belum ada ulasan dengan rating ini.</div>";
}
?>