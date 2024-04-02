<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <title>orphan_care</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/owl.carousel.css">

        <link rel="stylesheet" href="assets/css/style.css">

        <script src="assets/js/modernizr-2.6.2.min.js"></script>


        <style>
          body{
            overflow-x: hidden;
          }
          .navbar-nav>li {
              float: left;
              color: black;
          }

          .modal-open-scroll-lock {
          overflow: hidden;
          }
        </style>


    </head>

    <body>

    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "orphan_care";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Form data
    $name = $_POST["name"];
    $mail = $_POST["mail"];
    $message = $_POST["message"];

    // Insert data into database
    $sql = "INSERT INTO contact (name, mail, message) VALUES ('$name', '$mail', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "Message sent successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

    <header class="main-header">
        
    
        <nav class="navbar navbar-static-top">
            <div class="navbar-main">
              
              <div class="container">

                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">

                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>

                  </button>
                  
                  <a class="navbar-brand" href="start.php"><img src="assets/images/logo1.png" style="width: 50%;top: -11px;position: relative;" alt=""></a>
                  
                </div>

                <div id="navbar" class="navbar-collapse collapse pull-right">

                  <ul class="nav navbar-nav">

                    <li><a class="is-active" href="../login/login.php">Donor</a></li>
                    <li><a href="../trust/tlogin/tlogin.php">Trustee</a></li>

                  </ul>

                </div> <!-- /#navbar -->

              </div> <!-- /.container -->
              
            </div> <!-- /.navbar-main -->


        </nav> 

    </header> <!-- /. main-header -->

    <div id="homeCarousel" class="carousel slide carousel-home" data-ride="carousel">

          <!-- Indicators -->
          <ol class="carousel-indicators">
            <li data-target="#homeCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#homeCarousel" data-slide-to="1"></li>
            <li data-target="#homeCarousel" data-slide-to="2"></li>
          </ol>

          <div class="carousel-inner" role="listbox">

            <div class="item active">

              <img src="assets/images/slider/home-slider-1.jpg" alt="">

              <div class="container">

                <div class="carousel-caption">

                  <h2 class="carousel-title bounceInDown animated slow">Because they need your help</h2>
                  <h4 class="carousel-subtitle bounceInUp animated slow ">Do not let them down</h4>
                  <a href="starts.php" class="btn btn-lg btn-secondary hidden-xs bounceInUp animated slow" data-toggle="modal" style="border-radius: 16px;" data-target="#donateModal">DONATE NOW</a>

                </div> <!-- /.carousel-caption -->

              </div>

            </div> <!-- /.item -->


            <div class="item ">

              <img src="assets/images/slider/home-slider-2.jpg" alt="">

              <div class="container">

                <div class="carousel-caption">

                  <h2 class="carousel-title bounceInDown animated slow">Together we can improve their lives</h2>
                  <h4 class="carousel-subtitle bounceInUp animated slow"> So let's do it !</h4>
                  <a href="starts.php" class="btn btn-lg btn-secondary hidden-xs bounceInUp animated" data-toggle="modal" style="border-radius: 16px;" data-target="#donateModal">DONATE NOW</a>

                </div> <!-- /.carousel-caption -->

              </div>

            </div> <!-- /.item -->




            <div class="item ">

              <img src="assets/images/slider/home-slider-3.jpg" alt="">

              <div class="container">

                <div class="carousel-caption">

                  <h2 class="carousel-title bounceInDown animated slow" >That one rupee is big for someone who doesn't have even a single rupee</h2>
                  <h4 class="carousel-subtitle bounceInUp animated slow">You can make the diffrence !</h4>
                  <a href="starts.php" class="btn btn-lg btn-secondary hidden-xs bounceInUp animated slow" data-toggle="modal" style="border-radius: 16px;" data-target="#donateModal">DONATE NOW</a>

                </div> <!-- /.carousel-caption -->

              </div>

            </div> <!-- /.item -->

          </div>

          <a class="left carousel-control" href="#homeCarousel" role="button" data-slide="prev">
            <span class="fa fa-angle-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>

          <a class="right carousel-control" href="#homeCarousel" role="button" data-slide="next">
            <span class="fa fa-angle-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>

    </div><!-- /.carousel -->

    <div class="section-home about-us fadeIn animated">

        <div class="container">

            <div class="row">

                <div class="col-md-3 col-sm-6">
                
                  <div class="about-us-col">

                        <div class="col-icon-wrapper">
                          <img src="assets/images/icons/our-mission-icon.png" alt="">
                        </div>
                        <h3 class="col-title">our mission</h3>
                        <div class="col-details">

                          <p>Empowering lives, one smile at a time. Providing a nurturing haven for children, women, and the elderly, fostering hope and wellbeing in every individual we serve.</p>
                          
                        </div>
                        <!-- <a href="#" class="btn btn-primary"> Read more </a> -->
                    
                  </div>
                  
                </div>


                <div class="col-md-3 col-sm-6">
                
                  <div class="about-us-col">

                        <div class="col-icon-wrapper">
                          <img src="assets/images/icons/make-donation-icon.png" alt="">
                        </div>
                        <h3 class="col-title" style="font-size: 23px;">Make donations</h3>
                        <div class="col-details">

                          <p>Make a difference with every contribution. Your generosity fuels our mission, bringing joy and support to those in need.</p>
                          
                        </div>
                        <!-- <a href="#" class="btn btn-primary"> Read more </a> -->
                    
                  </div>
                  
                </div>


                <div class="col-md-3 col-sm-6">
                
                  <div class="about-us-col">

                        <div class="col-icon-wrapper">
                          <img src="assets/images/icons/help-icon.png" alt="">
                        </div>
                        <h3 class="col-title">Help & support</h3>
                        <div class="col-details">

                          <p>Supporting dreams, one act of kindness at a time. Together, we create a community of care, offering help and hope to those who need it most.</p>
                          
                        </div>
                        <!-- <a href="#" class="btn btn-primary"> Read more </a> -->
                    
                  </div>
                  
                </div>


                <div class="col-md-3 col-sm-6">
                
                  <div class="about-us-col">

                        <div class="col-icon-wrapper">
                          <img src="assets/images/icons/programs-icon.png" alt="">
                        </div>
                        <h3 class="col-title" style="font-size: 23px;">Nurturing Hope</h3>
                        <div class="col-details">

                          <p>Enriching Lives Across Generations and Abilities Transforming the Journey of Children, Women, Elderly, and Those in Need of Mental and Physical Support.</p>
                          
                        </div>
                        <!-- <a href="#" class="btn btn-primary"> Read more </a> -->
                    
                  </div>
                  
                </div>
                

                
            </div>

        </div>
      
    </div> <!-- /.about-us -->

    <div class="section-home home-reasons">

        <div class="container">

            <div class="row">
                
                <div class="col-md-6">

                    <div class="reasons-col animate-onscroll fadeIn">

                        <img src="assets/images/reasons/we-fight-togother.jpg" alt="">

                        <div class="reasons-titles">

                            <h3 class="reasons-title">We fight together</h3>
                            <h5 class="reason-subtitle">We are humans</h5>
                            
                        </div>

                        <div class="on-hover hidden-xs">
                            
                                <p style="font-size: 28px;"> We stand together in the journey of humanity, fighting for a world where kindness knows no limits. Our strength lies in the belief that by standing together, we weave a fabric of care, bringing hope, love, and inclusivity to every life we touch.</p>
                        </div>
                    </div>
                    
                </div>


                <div class="col-md-6">

                    <div class="reasons-col animate-onscroll fadeIn">

                        <img src="assets/images/reasons/old.jpg" alt="" style="height: 572px;">

                        <div class="reasons-titles">

                            <h3 class="reasons-title">WE care about others</h3>
                            <h5 class="reason-subtitle">We are humans</h5>
                            
                        </div>

                        <div class="on-hover hidden-xs">
                            
                                <p style="font-size: 26px;">We care about others because we are humans. It's a simple truth that drives our actions extending a helping hand, offering comfort, and sharing kindness. In every gesture, we reflect the essence of our humanity, fostering a world where compassion is our common language.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      

    </div> <!-- /.home-reasons -->

    <div class="section-home our-causes animate-onscroll fadeIn">

        <div class="container">

            <h2 class="title-style-1">Our Causes <span class="title-under"></span></h2>

            <div class="row">

                <div class="col-md-3 col-sm-6">

                    <div class="cause">

                        <img src="assets/images/causes/empower.jpg" alt="" class="cause-img">

                        <!-- <div class="progress cause-progress">
                          <div class="progress-bar" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%;">
                            10$ / 500$
                          </div>
                        </div> -->

                        <h4 class="cause-title"><a href="#">Empowering Futures </a></h4>
                        <div class="cause-details">
                          Nurturing children's dreams, providing a haven of hope and Supporting women's resilience, fostering empowerment in every endeavor.
                        </div>

                        <div class="btn-holder text-center">

                          <a href="starts.php" class="btn btn-primary" data-toggle="modal" data-target="#donateModal"> DONATE NOW</a>
                          
                        </div>
</div> <!-- /.cause -->
                    
                </div> 

                <div class="col-md-3 col-sm-6">

                    <div class="cause">

                        <img src="assets/images/causes/terasa.webp" style="height: 262px;" alt="" class="cause-img">
                        <h4 class="cause-title"><a href="#">Care Across Generations</a></h4>
                        <div class="cause-details">
                          Dedicating warmth to the elderly, where love knows no age and Embracing mental well-being, supporting minds on the path to shine.
                        </div>

                        <div class="btn-holder text-center">

                          <a href="starts.php" class="btn btn-primary" data-toggle="modal" data-target="#donateModal"> DONATE NOW</a>
                          
                        </div>

                        

                    </div> <!-- /.cause -->
                    
                </div>


                <div class="col-md-3 col-sm-6">

                    <div class="cause">

                        <img src="assets/images/causes/abilityy.jpeg" style="height: 262px;" alt="" class="cause-img">

                        <h4 class="cause-title"><a href="#">Championing Abilities</a></h4>
                        <div class="cause-details">
                          Breaking barriers, celebrating strength in every unique ability and Extending care to those with special needs, creating an inclusive community.
                        </div>

                        <div class="btn-holder text-center">

                          <a href="starts.php" class="btn btn-primary" data-toggle="modal" data-target="#donateModal"> DONATE NOW</a>
                          
                        </div>
                    </div> <!-- /.cause -->
                    
                </div>

                <div class="col-md-3 col-sm-6">

                    <div class="cause">

                        <img src="assets/images/causes/healing.png" style="height: 262px;" alt="" class="cause-img">
                        <h4 class="cause-title"><a href="#"> Healing Hearts </a></h4>
                        <div class="cause-details">
                          A sanctuary for the wounded, where compassion mends the soul and Dedicated to mental health, offering solace in times of struggle.
                        </div>

                        <div class="btn-holder text-center">

                          <a href="starts.php" class="btn btn-primary" data-toggle="modal" data-target="#donateModal"> DONATE NOW</a>
                          
                        </div>

                        

                    </div> <!-- /.cause -->
                    
                </div>

            </div>

        </div>
        
    </div> <!-- /.our-causes -->
    <footer class="main-footer">
        <div class="footer-top">
        </div>
        <div class="footer-main">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="footer-col">
                            <h4 class="footer-title">About us <span class="title-under"></span></h4>
                            <div class="footer-content">
                                <p style="font-size: 16px;">
                                    At <strong>Orphan Care</strong>, our mission is rooted in the belief that everyone deserves love and a chance to thrive. With a dedicated team, we provide a caring home for children, support resilient women, warmly embrace the elderly, champion unique abilities, and foster mental well-being.
                                </p> 
                            </div>
                            
                        </div>

                    </div>

                    <!-- <div class="col-md-4">

                        <div class="footer-col">

                            <h4 class="footer-title">LAST TWEETS <span class="title-under"></span></h4>

                            <div class="footer-content">
                                <ul class="tweets list-unstyled">
                                    <li class="tweet"> 

                                        20 Surprise Eggs, Kinder Surprise Cars 2 Thomas Spongebob Disney Pixar  http://t.co/fTSazikPd4 

                                    </li>

                                    <li class="tweet"> 

                                        20 Surprise Eggs, Kinder Surprise Cars 2 Thomas Spongebob Disney Pixar  http://t.co/fTSazikPd4 

                                    </li>

                                    <li class="tweet"> 

                                        20 Surprise Eggs, Kinder Surprise Cars 2 Thomas Spongebob Disney Pixar  http://t.co/fTSazikPd4 

                                    </li>

                                </ul>
                            </div>
                            
                        </div> -->

                    </div>


                    <div class="col-md-4" style="padding: 0px;">

                        <div class="footer-col">

                            <h4 class="footer-title">Contact us <span class="title-under"></span></h4>

                            <div class="footer-content">

                                <div class="footer-form">
                                    
                                    <div class="footer-form" >
                                    
                                    <form action="php/mail.php" class="ajax-form">

                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" placeholder="Name" required>
                                        </div>

                                         <div class="form-group">
                                            <input type="mail" name="mail" class="form-control" placeholder="E-mail" required>
                                        </div>

                                        <div class="form-group">
                                            <textarea name="message" class="form-control" placeholder="Message" required></textarea>
                                        </div>

                                        <div class="form-group alerts">
                        
                                            <div class="alert alert-success" role="alert">
                                              
                                            </div>

                                            <div class="alert alert-danger" role="alert">
                                              
                                            </div>
                                            
                                        </div>

                                         <div class="form-group">
                                            <button type="submit" class="btn btn-submit pull-right">Send message</button>
                                        </div>
                                    </form>
                                    <div style="bottom: 471px;left: 175%;position: relative;">
                                    <a class="navbar-brand" href="start.php"><img src="assets/images/logo4.png" style="width: 120%;height: 2661%;position: relative;" ></a>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </footer> 
    <div class="modal fade" id="donateModal" tabindex="-1" role="dialog" aria-labelledby="donateModalLabel" style="overflow: hidden;" aria-hidden="true">

      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="donateModalLabel">DONATE NOW</h4>
          </div>
          <div class="modal-body">

                <!-- <form class="form-donation"> -->
              <form action="" method="post" class="form-donation">

                        <h3 class="title-style-1 text-center">Thank you for your donation <span class="title-under"></span>  </h3>

                        <div class="row">

                            <div class="form-group col-md-12 ">
                                <input type="text" class="form-control" id="amount" placeholder="AMOUNT(€)">
                            </div>

                        </div>


                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="firstName" placeholder="First name*">
                            </div>

                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="lastName" placeholder="Last name*">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="mail" placeholder="mail*">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="phone" placeholder="Phone">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" name="address" placeholder="Address">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <textarea cols="30" rows="4" class="form-control" name="note" placeholder="Additional note"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <button type="button" class="btn btn-primary pull-right" onclick="window.location.href='start.php';" name="donateNow">DONATE NOW</button>
                            </div>
                        </div>
                </form>
          </div>
        </div>
      </div>
    </div> <!-- /.modal -->
    <script>window.jQuery || document.write('<script src="assets/js/jquery-1.11.1.min.js"><\/script>')</script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
    $(document).ready(function () {
        var modal = $('#donateModal');

        modal.on('show.bs.modal', function () {
            // Add the scroll lock class to the body when the modal is shown
            $('body').addClass('modal-open-scroll-lock');
        });

        modal.on('hidden.bs.modal', function () {
            // Remove the scroll lock class when the modal is hidden
            $('body').removeClass('modal-open-scroll-lock');
        });
    });
</script>

    

    </body>
</html>