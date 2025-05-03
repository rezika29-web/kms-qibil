<style>
.contentBaru {
    /* transition: filter 2s ease; */
	transform: translateX(-100%);
	transition: transform 1s ease-out, opacity 1s ease-out;

    filter: opacity(0); /* Awal: blur dan opacity 0 */
}

.visible {
	transform: translateX(0);
    filter: opacity(1); /* Akhir: jelas dan opacity penuh */
}
</style>

<section class="hero-area">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="block mt-4">
					<h1 class="wow fadeInUp" data-wow-duration=".5s" data-wow-delay=".3s">We are smart <br> Creative Agency</h1>
					<p class="wow fadeInUp" data-wow-duration=".5s" data-wow-delay=".5s">Lorem ipsum dolor sit amet, consectetur
						adipisicing elit. Nulla, ad rerum repellat. Sequi, labore, illo. Ducimus voluptates quidem obcaecati, ad.
					</p>
				</div>
			</div>
		</div>
	</div>
</section>

<!--
Start Blog Section
=========================================== -->
<section class="blog" id="blog">
	<div class="container">
		<div class="row justify-content-center">
			<!-- section title -->
			<div class="col-xl-6 col-lg-8">
				<div class="title text-center ">
					<h2> Articles</h2>
					<div class="border"></div>
					<p>Berikut beberapa article terbaru.</p>
				</div>
			</div>
			<!-- /section title -->
		</div>

		<div class="contentBaru" id="targetElement">
			<div class="row" id="articleList" >
			</div> <!-- end row -->
		</div> <!-- end row -->
	</div> <!-- end container -->
</section> <!-- end section -->


<script>
    // Menggunakan JavaScript untuk mendeteksi posisi scroll
    window.addEventListener('scroll', function () {
        const target = document.getElementById('targetElement');
        const rect = target.getBoundingClientRect();

        // Cek jika elemen terlihat di viewport
        if (rect.top < window.innerHeight && rect.bottom > 0) {
            target.classList.add('visible'); // Tambahkan class untuk efek
        } else {
            target.classList.remove('visible'); // Kembalikan ke blur
        }
    });
</script>