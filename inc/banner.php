<?php 
$query = "SELECT * FROM emitente";
$exec_query = mysqli_query($conn, $query);
$row_emitente = mysqli_fetch_assoc($exec_query);
?>
        
<section class="banner">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 col-md-6 col-sm-12 col-one">
                <div class="d-flex text-banner">
                    <h1 class="wow fadeInLeft"><b>Escolha sua batida <b class="color-primary">favorita.</b></b></h1>
                    <p class="wow fadeInLeft delay-02s">
                        Aproveite nossos produtos! Escolha o que desejar e receba em sua casa de forma rápida e segura.
                    </p>
                    <div class="wow fadeIn delay-05s">
                        <a href="#cardapio"class="btn btn-yellow mt-3 mr-3">
                            Ver produtos
                        </a>
                        <a href="tel:<?php echo $row_emitente['telefone'] ?>" class="btn btn-white btn-icon-left mt-3" id="btnLigar">
                            <span class="icon-left">
                                <i class="fa fa-phone"></i>
                            </span>
                            <?php echo $row_emitente['telefone'] ?> 
                        </a>
                    </div>
                </div>
                <a href="https://<?php echo $row_emitente['instagram'] ?>" target="_blank" class="btn btn-sm btn-white btn-social mt-4 mr-3 wow fadeIn delay-05s">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://<?php echo $row_emitente['facebook'] ?>" class="btn btn-sm btn-white btn-social mt-4 mr-3 wow fadeIn delay-05s">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://api.whatsapp.com/send/?phone=55<?php echo $row_emitente['whatsapp'] ?>&text=Olá! Gostaria de conversar " class="btn btn-sm btn-white btn-social mt-4 wow fadeIn delay-05s">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>

            <div class="col-6 no-mobile">
                <div class="card-banner wow fadeIn delay-02s"></div>
                <div class="d-flex img-banner wow fadeIn delay-05s">
                    <img src="./assets/img/banner1.png" />
                </div>
                <div class="card card-case wow fadeInRight delay-07s">
                    "Além da agilidade o preço, o atendimento e a qualidade dos produtos também surpreendem."
                    <span class="card-case-name">
                        <b>Thiago Lopes</b>
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>