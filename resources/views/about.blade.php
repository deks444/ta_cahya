@section('page-title', 'Visi & Misi DPM')
@extends('layout.layout')
@section('content')
    <!-- Blog Article -->
    <div class="max-w-3xl px-4 pt-6 lg:pt-10 pb-12 sm:px-6 lg:px-8 mx-auto">
        <div class="max-w-2xl">

            <!-- Content -->
            <div class="space-y-5 md:space-y-8">
                <div class="space-y-3 text-center">
                    <h2 class="text-2xl font-bold md:text-3xl">Dewan Perwakilan Mahasiswa</h2>
                    <h2 class="text-lg font-medium md:text-lg text-blue-600">ITB STIKOM Bali</h2>

                    <figure class="flex justify-center">
                        <img class="w-[500px] object-cover rounded-xl self-auto mx-auto"
                            src="{{ asset('img/LOGO DPM-PM.png') }}" alt="Logo DPM">
                    </figure>
                    <h1
                        class="text-2xl font-bold text-gray-800 md:text-2xl md:leading-normal xl:text-3xl xl:leading-normal mb-3 ">
                        Sejarah</h1>
                    <p class="text-lg text-gray-800 text-justify"> BALMA STMIK STIKOM Bali didirikan pada tanggal 20
                        September 2006 dengan hasil kesepakatan antara mahasiswa jurusan Teknik Komputer (S1) dan jurusan
                        Manajemen Informatika (D3) untuk membentuk Badan Legislatif Mahasiswa, yang kemudian pada tahun 2019
                        diubah menjadi BALMA ITB STIKOM Bali karena perubahan bentuk dari STMIK menjadi Institut, dengan
                        kesepakatan seluruh civitas kampus ITB STIKOM Bali, yang kemudian berubah menjadi DPM-PM-PM ITB
                        STIKOM Bali pada tanggal 19 Januari 2024 melalui Dialog Kebangsaan yang disahkan langsung oleh
                        Rektor ITB STIKOM Bali.</p>
                </div>


                <blockquote class="text-center">
                    <p class="text-3xl font-bold text-gray-800 md:text-3xl md:leading-normal xl:text-3xl xl:leading-normal">
                        VISI
                    </p>
                </blockquote>

                <p class="text-lg font-medium text-gray-800 text-center">Menjadikan DPM-PM ITB STIKOM Bali sebagai lembaga
                    yang
                    bersifat netral, mampu memberikan pengawasan dan menyalurkan aspirasi civitas kampus ITB STIKOM Bali
                    secara optimal.</p>

                <blockquote class="text-center">
                    <p class="text-3xl font-bold text-gray-800 md:text-3xl md:leading-normal xl:text-3xl xl:leading-normal">
                        MISI
                    </p>
                </blockquote>

                <div class="text-justify ">
                    <ol class="text-lg font-medium text-gray-800 list-outside list-decimal flex flex-col space-y-3">
                        <li>Melakukan pendampingan seluruh kegiatan ORMAWA ITB STIKOM Bali, mulai dari persiapan kegiatan
                            hingga hari H and setelah kegiatan.</li>
                        <li>Melakukan pendekatan baik secara personal maupun keorganisasian dengan harapan mau mendengarkan
                            aspirasi langsung dari Civitas Kampus ITB STIKOM Bali.</li>
                        <li>Membangun relasi yang baik dengan seluruh Civitas kampus ITB STIKOM Bali dan kampus luar ITB
                            STIKOM Bali.</li>
                        <li>Memperjuangkan seluruh aspirasi Mahasiswa hingga tuntas secara bertanggung jawab.</li>
                    </ol>
                </div>

            </div>
            <!-- End Content -->
        </div>
    </div>
    <!-- End Blog Article -->
@endsection