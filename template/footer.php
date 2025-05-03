<style>
  .boxDay {
    display: flex;
    justify-content: right;
    align-items: center;
    gap: 10px;
    margin-right: 50px;
  }
  .day {
    display: flex;
    width: auto;
    height: 55px;
    font-weight: bold;
    border-color: yellow;
    background-color: white;
    border-radius: 5px;
    padding-left: 10px;
    padding-right: 10px;
  }
</style>

<footer id="footer" class="bg-one">
  <div class="footer-bottom">
    <div class="boxDay">
      <div id="totalday" class="day"></div>
      <div id="totalFullday" class="day"></div>
    </div>
    <h5>&copy; Copyright 2024. All rights reserved.</h5>
    <h6>Design and Developed by <a href="http://127.0.0.1/Project/kms-fitri/">Kise Ryota</a></h6>
  </div>
</footer> <!-- end footer -->

<!-- end Footer Area
========================================== -->
<!-- 
    Essential Scripts
    =====================================-->
<!-- Main jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap4 -->
<script src="plugins/bootstrap/bootstrap.min.js"></script>
<!-- Parallax -->
<script src="plugins/parallax/jquery.parallax-1.1.3.js"></script>
<!-- lightbox -->
<script src="plugins/lightbox2/js/lightbox.min.js"></script>
<!-- Owl Carousel -->
<script src="plugins/slick/slick.min.js"></script>
<!-- filter -->
<script src="plugins/filterizr/jquery.filterizr.min.js"></script>
<!-- Smooth Scroll js -->
<script src="plugins/smooth-scroll/smooth-scroll.min.js"></script>
<!-- Google Map -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU"></script>
<script src="plugins/google-map/gmap.js"></script>

<!-- Custom js -->
<script src="js/script.js"></script>

<script>
  $(document).ready(function() {
        // Request data dari server
        $.ajax({
            url: 'http://localhost:1337/api/kategoris', // Ganti dengan URL server Anda
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                let resData = data.data;
                // Bersihkan daftar pengguna sebelumnya
                $('#kategoriList').empty();
                $('#kategoriListSide').empty();

                // Looping data dan tambahkan ke elemen HTML
                $.each(resData, function(index, dt) {
                    $('#kategoriList').append('<li><a class="dropdown-item" href="listarticle.php?id='+ dt.documentId + '">'+ dt.Kategori + '</a>' +'</li>');
                    $('#kategoriListSide').append('<li><a href="listarticle.php?id='+ dt.documentId + '">'+ dt.Kategori + '</a>' +'</li>');
                });
            },
            error: function(error) {
                alert('Gagal memuat data!');
                console.error(error);
            }
        });
});
</script>

<script>
  let tglN = new Date;
  $(document).ready(function() {
        // Request data dari server
        
        let totalDatas = 0;
        let totalDay = 0;
        $.ajax({
            url: 'http://localhost:1337/api/total-urls', // Ganti dengan URL server Anda
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                let resData = data.data;
                let formattedDate = new Date;
                var d = formattedDate.getDate();
                var m =  formattedDate.getMonth();
                m += 1;  // JavaScript months are 0-11
                var y = formattedDate.getFullYear();

                let final = y+'-'+ (m < 10 ? '0'+m : m )+'-'+ (d < 10 ? '0'+d : d )

                if(resData.length == 0){
                  let tglN = new Date;

                  let reqBody = {
                      "data": {
                          "total": 1,
                          "tanggal_sekarang": tglN.toISOString()
                      }
                  }

                  $.post("http://localhost:1337/api/total-urls", reqBody, function(result){
                    totalDay = 1;
                    totalDatas = 1;
                  }).fail(function (xhr, status, error) {
                    console.log('====================================');
                    console.log("total url ", error);
                    console.log('====================================');
                  }); 
                  $('#totalday').append('<p>Hari ini :<br /> 1 </p>');
                  $('#totalFullday').append('<p>Total : <br /> 1 </p>');
                }else{
                  let docIdDay;
                  $.each(resData, function(index, dt) {
                      if(String(dt.tanggal_sekarang) == String(final)){
                        docIdDay = dt.documentId
                        totalDay = Number(totalDay) + Number(dt.total);
                      }
                      totalDatas = (Number(totalDatas) + Number(dt.total))
                  });

                  if(totalDay == 0){
                      let tglN = new Date;
                      let reqBody = {
                          "data": {
                              "total": 1,
                              "tanggal_sekarang": tglN.toISOString()
                          }
                      }

                      $.post("http://localhost:1337/api/total-urls", reqBody, function(result){
                        totalDay = 1;
                        totalDatas = 1;
                      }).fail(function (xhr, status, error) {
                        console.log("error ", error);
                      }); 
                      $('#totalday').append('<p>Hari ini :<br /> 1 </p>');
                  }else{
                    let tglN = new Date;

                    totalDay = totalDay + 1;
                    totalDatas = totalDatas + 1;
                    let reqBody = {
                        "data": {
                            "total": totalDay
                        },
                        "meta": {}
                    }
                    $.ajax({
                        url: 'http://localhost:1337/api/total-urls/' + docIdDay, // Ganti dengan URL server Anda
                        method: 'PUT',
                        data: reqBody,
                        dataType: 'json',
                        success: function(data) {
                          return data.data;
                        },
                        error: function(error) {
                          return error;
                        }
                    });
                    $('#totalday').append('<p>Hari ini :<br /> '+ totalDay + '</p>');
                  }
                  $('#totalFullday').append('<p>Total : <br /> '+ String(totalDatas) + '</p>');
                }
            },
            error: function(error) {
                let tglN = new Date;

                let reqBody = {
                    "data": {
                        "total": 1,
                        "tanggal_sekarang": tglN.toISOString()
                    }
                }

                $.post("http://localhost:1337/api/total-urls", reqBody, function(result){
                  totalDay = 1;
                  totalDatas = 1;
                }).fail(function (xhr, status, error) {
                  console.log('====================================');
                  console.log("total url ", error);
                  console.log('====================================');
                }); 
                $('#totalday').append('<p>Hari ini :<br /> '+ totalDay + '</p>');
                $('#totalFullday').append('<p>Total : <br /> '+ String(totalDatas) + '</p>');
            }
        });
});
</script>

</body>

</html>
