<script>
  const images = ["/ue/image/acueil_3.jpg", "/ue/image/acueil_2.jpg", "/ue/image/acueil_1.jpg"];
  let current = 0;

  const mainImage = document.getElementById('mainImage');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');

  function showImage(index) {
    mainImage.src = images[index];
  }
  prevBtn.onclick = function() {
    current = (current - 1 + images.length) % images.length;
    showImage(current);
  };
  nextBtn.onclick = function() {
    current = (current + 1) % images.length;
    showImage(current);
  };
  showImage(current);
</script>