<div x-data="searchComponent()" x-init="init()" @click.away="showResults = false" class="relative w-full max-w-lg">
    <input
        type="text"
        placeholder="Cari data warga, surat, info desa..."
        x-model="query"
        @input="filterResults()"
        class="w-full pl-11 pr-4 py-2 rounded-full bg-gray-100 focus:bg-white border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition text-sm text-gray-700 shadow-sm"
    />
    <div class="absolute inset-y-0 left-4 flex items-center text-gray-400">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
        </svg>
    </div>

    <div x-show="showResults" class="absolute z-50 w-full bg-white mt-2 rounded-xl shadow-lg border border-gray-200 max-h-60 overflow-y-auto">
        <template x-for="(result, index) in results" :key="index">
            <a
                href="#"
                @click.prevent="handleClick(result)"
                class="block px-4 py-2 text-sm hover:bg-blue-50 text-gray-700"
                x-text="result.label"
            ></a>
        </template>
    </div>
</div>

<script>
    function searchComponent() {
        return {
            query: '',
            results: [],
            showResults: false,
            data: [
                { label: 'Beranda', href: '/dashboard' },
                { label: 'Sejarah Desa', id: 'menu-sejarah-desa', href: '/profil/sejarah-desa' },
                { label: 'Demografi', id: 'menu-demografi', href: '/profil/demografi' },
                { label: 'Visi & Misi', id: 'menu-visi-misi', href: '/profil/visi-misi' },
                { label: 'Struktur Pemerintahan', id: 'menu-struktur-pemerintahan', href: '/profil/struktur-pemerintahan' },
                { label: 'Infrastruktur Desa', id: 'menu-infrastruktur-desa', href: '/profil/infrastruktur-desa' },
                { label: 'Wilayah Administrasi', id: 'menu-wilayah-administrasi', href: '/profil/wilayah' },
                { label: 'Layanan Administrasi', id: 'menu-layanan-administrasi', href: '/admin/layanan/administrasi' },
                { label: 'Pengaduan Masyarakat', id: 'menu-pengaduan-masyarakat', href: '/admin/layanan/pengaduan' },
                { label: 'Berita Desa', id: 'menu-berita-desa', href: '/admin/berita' },
                { label: 'Pengumuman', id: 'menu-pengumuman', href: '/admin/pengumuman' },
                { label: 'Profil', id: 'menu-profil', href: '/admin/akun' },
                { label: 'Kelola Akun Warga', id: 'menu-kelola-akun-warga', href: '/admin/akun-warga' },
                { label: 'Kependudukan', id: 'menu-kependudukan', href: '/admin/kependudukan' },
                { label: 'APBDes', id: 'menu-apbdes', href: '/admin/apbdes' },
                { label: 'Logout', id: 'menu-logout' }
            ],
            init() {
                this.results = this.data;
            },
            filterResults() {
                this.results = this.data.filter(item =>
                    item.label.toLowerCase().includes(this.query.toLowerCase())
                );
                this.showResults = this.query.length > 0;
            },
            handleClick(result) {
                const currentPath = window.location.pathname;
                const targetPath = new URL(result.href ?? '', window.location.origin).pathname;

                // Jika lagi di halaman yang sama dan ada ID → scroll
                if (result.id && currentPath === targetPath) {
                    const el = document.getElementById(result.id);
                    if (el) {
                        el.scrollIntoView({ behavior: 'smooth' });
                        el.classList.add('bg-yellow-100');
                        setTimeout(() => el.classList.remove('bg-yellow-100'), 1000);
                    }
                } else if (result.href) {
                    window.location.href = result.href;
                }

                this.showResults = false;
                this.query = '';
            }
        }
    }
</script>
