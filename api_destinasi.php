<script>
// KONFIGURASI API
const API_KEY = 'https://api.openweathermap.org/data/2.5/forecast?lat=-7.9&lon=112.9&appid=c4752a971021db39a254799794cedd5b'; // Ganti dengan API Key Anda
const LAT = '-7.9425'; // Latitude Bromo
const LON = '112.9530'; // Longitude Bromo

let weatherData = [];

async function fetchWeather() {
    try {
        const response = await fetch(`https://api.openweathermap.org/data/2.5/forecast?lat=${LAT}&lon=${LON}&appid=${API_KEY}&units=metric&lang=id`);
        const data = await response.json();
        
        // Mengambil data jam 12 siang untuk setiap hari (prediksi 5 hari)
        weatherData = data.list.filter(item => item.dt_txt.includes("12:00:00"));
        renderTabs();
        showDetail(0); // Set hari pertama sebagai default aktif
    } catch (error) {
        console.error("Gagal mengambil data cuaca:", error);
        document.getElementById('weather-main').innerHTML = "<p>Gagal memuat cuaca.</p>";
    }
}

function renderTabs() {
    const tabsContainer = document.getElementById('weather-tabs');
    tabsContainer.innerHTML = '';

    weatherData.forEach((day, index) => {
        const date = new Date(day.dt * 1000);
        const options = { weekday: 'short', day: 'numeric', month: 'short' };
        const dateString = date.toLocaleDateString('en-US', options);

        const btn = document.createElement('button');
        btn.id = `tab-${index}`;
        btn.className = `weather-tab px-4 py-2 rounded-xl transition-all font-bold whitespace-nowrap ${index === 0 ? 'bg-white text-[#0e5e6f]' : 'opacity-60 hover:opacity-100'}`;
        btn.innerText = dateString;
        btn.onclick = () => showDetail(index);
        tabsContainer.appendChild(btn);
    });
}

function showDetail(index) {
    const data = weatherData[index];
    const mainContainer = document.getElementById('weather-main');
    const detailsContainer = document.getElementById('weather-details');

    // Update style tombol aktif
    document.querySelectorAll('.weather-tab').forEach(t => {
        t.classList.remove('bg-white', 'text-[#0e5e6f]');
        t.classList.add('opacity-60');
    });
    const activeTab = document.getElementById(`tab-${index}`);
    activeTab.classList.add('bg-white', 'text-[#0e5e6f]');
    activeTab.classList.remove('opacity-60');

    // Update Gambar Ikon dan Suhu
    const iconUrl = `https://openweathermap.org/img/wn/${data.weather[0].icon}@4x.png`;
    mainContainer.innerHTML = `
        <img src="${iconUrl}" class="w-32 h-32 -mb-4" alt="icon">
        <div class="text-6xl font-black">${Math.round(data.main.temp)}°C</div>
        <p class="mt-2 text-lg font-medium capitalize">Terasa seperti ${Math.round(data.main.feels_like)}°C | ${data.weather[0].description}</p>
    `;

    // Update Grid Rincian (Angin, Tekanan, Kelembaban, Jarak Pandang)
    detailsContainer.innerHTML = `
        <div><i class="bi bi-wind"></i> <p>${data.wind.speed} km/h</p></div>
        <div><i class="bi bi-speedometer"></i> <p>${data.main.pressure} hPa</p></div>
        <div><i class="bi bi-droplets"></i> <p>${data.main.humidity}%</p></div>
        <div><i class="bi bi-eye"></i> <p>${(data.visibility / 1000).toFixed(1)} km</p></div>
    `;
}

// Jalankan saat halaman dibuka
fetchWeather();
</script>