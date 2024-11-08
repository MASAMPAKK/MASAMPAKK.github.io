function showTicketModal(pesanan) {
    document.getElementById('ticket-event-name').innerText = pesanan.nama_event;
    document.getElementById('ticket-waktu-event').innerText = pesanan.waktu_event;
    document.getElementById('ticket-tanggal-event').innerText = pesanan.tanggal_event;
    document.getElementById('ticket-lokasi-event').innerText = pesanan.lokasi_event;
    document.getElementById('ticket-jumlah-tiket').innerText = pesanan.jumlah_tiket;
    document.getElementById('ticket-tanggal-pemesanan').innerText = pesanan.tanggal_pemesanan;

    document.getElementById('ticketModal').style.display = 'block';
}

function closeTicketModal() {
    document.getElementById('ticketModal').style.display = 'none';
}