<?php
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
requireAdmin();

$activeLink = 'tiket_wisata.php';
$pageTitle  = 'MadiunTrack - Tiket Wisata';
$notif = '';

// ---------------------------------------------------------------------
// AKSI: tambah / edit / hapus
// ---------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo) {
    $action = $_POST['action'] ?? '';

    if ($action === 'save') {
        $id                = $_POST['id'] ?? null;
        $pengguna_id       = $_POST['pengguna_id'];
        $destinasi_id      = $_POST['destinasi_id'];
        $tanggal_kunjungan = $_POST['tanggal_kunjungan'];
        $jumlah            = (int)$_POST['jumlah'];
        $total_harga       = (float)$_POST['total_harga'];
        $status            = $_POST['status'];

        if ($id) {
            $stmt = $pdo->prepare("UPDATE tiket_wisata SET pengguna_id=?, destinasi_id=?, tanggal_kunjungan=?, jumlah=?, total_harga=?, status=? WHERE id=?");
            $stmt->execute([$pengguna_id, $destinasi_id, $tanggal_kunjungan, $jumlah, $total_harga, $status, $id]);
            $notif = 'Data tiket berhasil diperbarui.';
        } else {
            $kode = 'TKT-' . strtoupper(uniqid());
            $stmt = $pdo->prepare("INSERT INTO tiket_wisata (kode_tiket, pengguna_id, destinasi_id, tanggal_kunjungan, jumlah, total_harga, status) VALUES (?,?,?,?,?,?,?)");
            $stmt->execute([$kode, $pengguna_id, $destinasi_id, $tanggal_kunjungan, $jumlah, $total_harga, $status]);
            $notif = 'Data tiket berhasil ditambahkan.';
        }
    } elseif ($action === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM tiket_wisata WHERE id=?");
        $stmt->execute([$_POST['id']]);
        $notif = 'Data tiket berhasil dihapus.';
    }
}

// ---------------------------------------------------------------------
// AMBIL DATA
// ---------------------------------------------------------------------
$tickets = [];
$destinasiList = [];
$penggunaList = [];

if ($pdo) {
    try {
        $tickets = $pdo->query("
            SELECT t.*, p.nama AS nama_pembeli, d.nama AS nama_destinasi
            FROM tiket_wisata t
            JOIN pengguna p ON p.id = t.pengguna_id
            JOIN destinasi_wisata d ON d.id = t.destinasi_id
            ORDER BY t.created_at DESC
        ")->fetchAll();
        $destinasiList = $pdo->query("SELECT id, nama FROM destinasi_wisata WHERE status='aktif' ORDER BY nama")->fetchAll();
        $penggunaList  = $pdo->query("SELECT id, nama FROM pengguna WHERE role='user' ORDER BY nama")->fetchAll();
    } catch (\PDOException $e) {
        $notif = 'Tabel belum tersedia. Silakan impor schema.sql terlebih dahulu.';
    }
}

// Fallback dummy data (dipakai jika DB belum tersambung/tabel kosong)
if (!$pdo || empty($tickets)) {
    $tickets = [
        ['id'=>1,'kode_tiket'=>'TKT-0001','nama_pembeli'=>'Rara','nama_destinasi'=>'Pahlawan Street Center (PSC)','tanggal_kunjungan'=>'2026-05-26','jumlah'=>2,'total_harga'=>40000,'status'=>'Diproses'],
        ['id'=>2,'kode_tiket'=>'TKT-0002','nama_pembeli'=>'Budi Santoso','nama_destinasi'=>'Taman Bantaran Kali Madiun','tanggal_kunjungan'=>'2026-05-25','jumlah'=>4,'total_harga'=>80000,'status'=>'Selesai'],
        ['id'=>3,'kode_tiket'=>'TKT-0003','nama_pembeli'=>'Siti Aisyah','nama_destinasi'=>'Taman Sumber Umis','tanggal_kunjungan'=>'2026-05-25','jumlah'=>2,'total_harga'=>40000,'status'=>'Diproses'],
    ];
}

include __DIR__ . '/includes/layout_head.php';
?>

<div class="flex items-center justify-between mb-1 flex-wrap gap-3">
    <div>
        <h1 class="text-2xl font-semibold m-0 mb-1 text-slate-900">Tiket Wisata</h1>
        <p class="text-slate-500 text-sm m-0">Kelola seluruh transaksi tiket wisata dari pengunjung.</p>
    </div>
    <button onclick="bukaModal()" class="flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white font-semibold text-sm px-4 py-2.5 rounded-xl transition-colors cursor-pointer">
        <?= icon('plus', 16, '#fff') ?> Tambah Tiket
    </button>
</div>

<?php if ($notif): ?>
    <div class="mt-4 bg-blue-50 text-blue-700 text-sm font-medium px-4 py-3 rounded-xl"><?= htmlspecialchars($notif) ?></div>
<?php endif; ?>

<div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm mt-5">
    <div class="overflow-x-auto">
    <table class="w-full border-collapse text-[13px] min-w-[750px]">
        <thead>
            <tr class="text-left">
                <th class="text-[11px] font-bold text-slate-400 tracking-wide px-2.5 pb-3 border-b border-slate-200">Kode</th>
                <th class="text-[11px] font-bold text-slate-400 tracking-wide px-2.5 pb-3 border-b border-slate-200">Nama Pembeli</th>
                <th class="text-[11px] font-bold text-slate-400 tracking-wide px-2.5 pb-3 border-b border-slate-200">Destinasi</th>
                <th class="text-[11px] font-bold text-slate-400 tracking-wide px-2.5 pb-3 border-b border-slate-200">Tanggal</th>
                <th class="text-[11px] font-bold text-slate-400 tracking-wide px-2.5 pb-3 border-b border-slate-200">Jumlah</th>
                <th class="text-[11px] font-bold text-slate-400 tracking-wide px-2.5 pb-3 border-b border-slate-200">Total</th>
                <th class="text-[11px] font-bold text-slate-400 tracking-wide px-2.5 pb-3 border-b border-slate-200">Status</th>
                <th class="text-[11px] font-bold text-slate-400 tracking-wide px-2.5 pb-3 border-b border-slate-200">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tickets as $t): ?>
                <tr>
                    <td class="py-3.5 px-2.5 border-b border-slate-100 font-medium text-slate-800"><?= htmlspecialchars($t['kode_tiket']) ?></td>
                    <td class="py-3.5 px-2.5 border-b border-slate-100 font-medium text-slate-800"><?= htmlspecialchars($t['nama_pembeli']) ?></td>
                    <td class="py-3.5 px-2.5 border-b border-slate-100 font-medium text-slate-800"><?= htmlspecialchars($t['nama_destinasi']) ?></td>
                    <td class="py-3.5 px-2.5 border-b border-slate-100 font-medium text-slate-800"><?= tanggalIndo($t['tanggal_kunjungan']) ?></td>
                    <td class="py-3.5 px-2.5 border-b border-slate-100 font-medium text-slate-800"><?= (int)$t['jumlah'] ?></td>
                    <td class="py-3.5 px-2.5 border-b border-slate-100 font-medium text-slate-800"><?= rupiah($t['total_harga']) ?></td>
                    <td class="py-3.5 px-2.5 border-b border-slate-100"><?= pillStatus($t['status']) ?></td>
                    <td class="py-3.5 px-2.5 border-b border-slate-100">
                        <div class="flex gap-1.5">
                            <button onclick='editData(<?= json_encode($t) ?>)' class="w-8 h-8 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center border-none cursor-pointer"><?= icon('edit', 14) ?></button>
                            <form method="post" onsubmit="return confirm('Hapus tiket ini?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= (int)$t['id'] ?>">
                                <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center border-none cursor-pointer"><?= icon('trash', 14) ?></button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>

<!-- MODAL TAMBAH / EDIT -->
<div id="modalForm" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-lg">
        <div class="flex items-center justify-between mb-4">
            <h3 id="modalTitle" class="text-lg font-semibold m-0">Tambah Tiket</h3>
            <button onclick="tutupModal()" class="border-none bg-transparent cursor-pointer text-slate-400"><?= icon('x', 18) ?></button>
        </div>
        <form method="post" class="flex flex-col gap-3">
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="id" id="f_id">

            <label class="text-xs font-semibold text-slate-500">Pembeli
                <select name="pengguna_id" id="f_pengguna" required class="w-full mt-1 border border-slate-200 rounded-lg px-3 py-2 text-sm">
                    <?php foreach ($penggunaList as $p): ?>
                        <option value="<?= (int)$p['id'] ?>"><?= htmlspecialchars($p['nama']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label class="text-xs font-semibold text-slate-500">Destinasi
                <select name="destinasi_id" id="f_destinasi" required class="w-full mt-1 border border-slate-200 rounded-lg px-3 py-2 text-sm">
                    <?php foreach ($destinasiList as $d): ?>
                        <option value="<?= (int)$d['id'] ?>"><?= htmlspecialchars($d['nama']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label class="text-xs font-semibold text-slate-500">Tanggal Kunjungan
                <input type="date" name="tanggal_kunjungan" id="f_tanggal" required class="w-full mt-1 border border-slate-200 rounded-lg px-3 py-2 text-sm">
            </label>

            <div class="grid grid-cols-2 gap-3">
                <label class="text-xs font-semibold text-slate-500">Jumlah
                    <input type="number" min="1" name="jumlah" id="f_jumlah" required class="w-full mt-1 border border-slate-200 rounded-lg px-3 py-2 text-sm">
                </label>
                <label class="text-xs font-semibold text-slate-500">Total Harga
                    <input type="number" min="0" name="total_harga" id="f_total" required class="w-full mt-1 border border-slate-200 rounded-lg px-3 py-2 text-sm">
                </label>
            </div>

            <label class="text-xs font-semibold text-slate-500">Status
                <select name="status" id="f_status" class="w-full mt-1 border border-slate-200 rounded-lg px-3 py-2 text-sm">
                    <option value="Diproses">Diproses</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Dibatalkan">Dibatalkan</option>
                </select>
            </label>

            <button type="submit" class="mt-2 bg-blue-700 hover:bg-blue-800 text-white font-semibold text-sm py-2.5 rounded-xl cursor-pointer">Simpan</button>
        </form>
    </div>
</div>

<script>
function bukaModal() {
    document.getElementById('modalTitle').textContent = 'Tambah Tiket';
    document.getElementById('f_id').value = '';
    document.getElementById('modalForm').classList.remove('hidden');
    document.getElementById('modalForm').classList.add('flex');
}
function tutupModal() {
    document.getElementById('modalForm').classList.add('hidden');
    document.getElementById('modalForm').classList.remove('flex');
}
function editData(t) {
    document.getElementById('modalTitle').textContent = 'Edit Tiket';
    document.getElementById('f_id').value = t.id;
    document.getElementById('f_pengguna').value = t.pengguna_id || '';
    document.getElementById('f_destinasi').value = t.destinasi_id || '';
    document.getElementById('f_tanggal').value = t.tanggal_kunjungan;
    document.getElementById('f_jumlah').value = t.jumlah;
    document.getElementById('f_total').value = t.total_harga;
    document.getElementById('f_status').value = t.status;
    document.getElementById('modalForm').classList.remove('hidden');
    document.getElementById('modalForm').classList.add('flex');
}
</script>

<?php include __DIR__ . '/includes/layout_foot.php'; ?>