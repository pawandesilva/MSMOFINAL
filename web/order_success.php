<?php
session_start();
include 'customer_layout.php';
?>
<script>
Swal.fire({
  position: "center",
  icon: "success",
  title: "Your Order has been saved",
  showConfirmButton: false,
  timer: 1500
});
</script>
<div class="container-fluid contact py-5">
    <div class="container py-5">
<main id="main">
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">
            <div class="section-title align-content-center">
                <h2 class="text-success text-center py-2">-SUCCESS-</h2>
                
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-7 border border-4 border-success" data-aos="fade-up" data-aos-delay="200">
                    <h1 class="text-center">Congratulations!!</h1><br>
                    <h2>Your Order has been successfully created!!</h2>
                    <h1 class="text-center">Order number is:<?= $_SESSION['ONO']?></h1>
                </div>
            </div>
        </div>
        </section>
</main>
    </div>
</div>
<?php
include 'footer.php';
?>

