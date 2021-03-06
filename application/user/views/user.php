<?php require_once("/../models/user.php"); $model = new ModelUser(); if(!$model->isValidUser()) header('Location: login.php');?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Womics | Adrian Mihaila & Saveluc Diana</title>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <link rel="stylesheet" type="text/css" href="../../../assets/css/main.css" /> 
        <link rel="stylesheet" type="text/css" media="all" href="../../../assets/css/jquery.hoverscroll.css" />
        
        <script type="text/javascript" src="../../../assets/js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="../../../assets/js/jquery.hoverscroll.js"></script>
        

        <script type="text/javascript">
            
            $(document).ready(function(){
                $.fn.hoverscroll.params = $.extend($.fn.hoverscroll.params, {
                    vertical : false,
                    width: 980,
                    height: 270,
                    arrows: false
                });
                $('#horizontal-scooters-history').hoverscroll();  
                
                $("#members-area").mouseover(function() {
                        $("#members-area-content").show();
                        $("#weather-content").hide();
                        $("#currency-content").hide();
                  }).mouseout(function(){
                        $("#members-area-content").mouseenter(function() {
                                $("#members-area-content").show(); 
                        }).mouseleave(function() {
                                $("#members-area-content").hide();
                        });        
                });
                
                $("#weather").mouseover(function() {
                        $("#members-area-content").hide();
                        $("#weather-content").show();
                        $("#currency-content").hide();
                  }).mouseout(function(){
                        $("#weather-content").mouseenter(function() {
                                $("#weather-content").show(); 
                        }).mouseleave(function() {
                                $("#weather-content").hide();
                        });        
                });  
                
                $("#currency").mouseover(function() {
                        $("#members-area-content").hide();
                        $("#currency-content").show();
                        $("#weather-content").hide();
                  }).mouseout(function(){
                        $("#currency-content").mouseenter(function() {
                                $("#currency-content").show(); 
                        }).mouseleave(function() {
                                $("#currency-content").hide();
                        });        
                });  

                                     
            });
                           
            function Logout(){
                deleteCookie('user_id');
                deleteCookie('user_session_id');
                window.location.href = "login.php";
            }
            function deleteCookie(name) {
                var date = new Date();
                date.setTime(date.getTime()+(-1*24*60*60*1000));
                var expires = " expires="+date.toGMTString();
                document.cookie = name+"=;"+expires+"; path=/";
            }
            function selectOras(judet){
                var judete = <?php echo JUDET; ?>;
                
                var orasSelect = document.getElementById("oras");
                var form = document.getElementById("form-signup");
                var judetLabel = document.getElementById("judet");
                var divSelect = document.getElementById('search-judet');
                
                if(orasSelect != null){
                    form.removeChild(document.getElementById("login-label-oras")); 
                    form.removeChild(document.getElementById("search-oras"));     
                }
                
                var select = document.createElement("select");
                select.setAttribute("name", "oras");
                select.id="oras";
                
                for(var oras in judete[judet.value]){
                    var option = document.createElement("option");
                    option.setAttribute("value", oras);
                    option.innerHTML = oras;
                    select.appendChild(option);
                }
                var div = document.createElement("div");
                div.className = "search-select";
                div.id = "search-oras";
                
                var label = document.createElement("label");
                label.className = "login-label";
                label.id = "login-label-oras";
                label.innerHTML = "Oras";
                
                div.appendChild(label); 
                div.appendChild(select);
                divSelect.parentNode.insertBefore(label, divSelect.nextSibling);  
                label.parentNode.insertBefore(div, label.nextSibling); 
            }
        </script> 
    </head>
    <body> 
        <?php $result = $model->getUser(); ?>         
            <header>
                <div class="content">
                    <div id="logo">
                        <a href="default.php" title="WildRide"><img src="../../../img/logo.png" alt="WildRide"/></a>
                    </div>
                    <div id="navigator">
                    <nav>
                        <a href="about-us.php" title="About Us">about us</a>
                        <a href="special-offers.php" title="Special Offers">special offers</a>
                        <a href="reservation.php" title="Rezervation">rezervation</a>
                        <a href="contact.php" title="Contact">contact</a>
                    </nav>
                </div>
                </div>
                        
            </header>
                <section id="container">
                    <div class="content">
                        <div id="user-navigator">
                            <ul>
                                <li><a href="orders.php" title="View Orders History">Orders History</a></li>
                                <li><a href="change-email.php" title="Change Email Login">Change Email Login</a></li>
                                <li><a href="change-password.php" title="Change Password Login">Change Password Login</a></li>
                            </ul>
                        </div>    
                        <div id="user-information">
                            <form action="../controllers/user.php?action=edit&id=<?php echo $result['id']; ?>" method="POST" id="form-signup">               
                                <label class="login-label">
                                    First Name
                                </label>
                                
                                <input type="text" name="first_name" class="login-input" value="<?php echo $result['nume']; ?>" />
                                
                                <label class="login-label">
                                    Last Name
                                </label>
                                
                                <input type="text" name="last_name" class="login-input" value="<?php echo $result['prenume']; ?>" />
                                
                                
                                <label class="login-label">
                                    CNP
                                </label>
                                
                                <input type="text" name="cnp" id="cnp" class="login-input" maxlength="13" value="<?php echo $result['cnp']; ?>"/>
                                
                                <label class="login-label">
                                    Judet
                                </label>
                                <div class="search-select" id="search-judet">
                                <select name="judet" onchange="selectOras(this);" id="judet">
                                     <?php 
                                     foreach( json_decode(JUDET) as $item => $key){
                                        if($result['judet'] == $item) $selected = 'selected="selected"';
                                            else $selected = '';
                                        echo '<option value="'.$item.'" '.$selected.'>'.$item.'</option>';    
                                     }
                                     ?>
                                </select>
                                </div>
                                
                                <label class="login-label" id="login-label-oras">Oras</label>
                                <div class="search-select" id="search-oras">
                                <select name="oras" id="oras">
                                     <?php 
                                     foreach( json_decode(JUDET) as $item => $key){
                                        foreach($key as $item1 => $key1){                               
                                            if($result['oras'] == $item1) $selected = 'selected="selected"';
                                                else $selected = '';
                                            echo '<option value="'.$item1.'" '.$selected.'>'.$item1.'</option>';
                                        }    
                                     }
                                     ?>
                                </select>
                                </div>
                                
                                <label class="login-label">
                                    Seria
                                </label>
                                
                                <input type="text" name="serie" id="serie" class="login-input" value="<?php echo $result['serie'];?>"/>
                                
                                <label class="login-label">
                                    Numar
                                </label>                  
                       
                                <input type="text" name="numar" id="numar" class="login-input" value="<?php echo $result['numar'];?>"/>
                                
                                
                                <input type="submit" value="Update" name="update"/>  
                            </form>
                        </div>
                    </div>
                </section>
                <section id="scooter-history">
                    <div class="content">
                         <h2>History Views</h2>
                         <ul id="horizontal-scooters-history">
                                <?php echo $model->getScootersHistory(); ?>   
                         </ul>
                    </div>
                </section>
                <section id="aditional-tool"> 
                    <div id="members-area">
                        <div id="members-area-content">
                            <h3>Members Area</h3>
                            <h4><?php 
                                if(is_array($result)){
                                    echo 'Bune ai venit, <a href="../controllers/user.php?action=view&id='.$result['id'].'"> ' . $result['nume'] ." ". $result['prenume'] ."</a>!</h4>";
                                    echo '<input type="button" value="Logout" onclick="Logout()" class="input-logout"/>';
                                }else{
                                    echo 'Welcome guest!</br>Please</h4>
                                            <input type="button" value="Sign In"/>
                                            <div id="members-area-login">or</div>
                                            <input type="button" value="Sign Up"/>'; 
                                }                            
                            ?>
                        </div>                        
                    </div>
                    <div id="weather">
                        <div id="weather-content">
                            <h3>Current Weather</h3>
                            <?php $model->getWeather($temp_c,$img_url,$loc);?>
                            <div id="weather-content-img"><img src="<?php echo $img_url;?>" alt="" /></div>
                            <div id="weather-location"><?php echo $loc; ?></div>
                            <div id="weather-temp"><?php echo $temp_c . '°C'; ?></div>
                            <input type="button" value="More"/> 
                        </div>                        
                    </div>
                    <div id="currency"> 
                        <div id="currency-content">
                            <?php $rates = $model->getExchangeRates();?>
                            <h3>Currency Rates</h3>
                            <ul>
                                <li><img src="../../../img/eur.png" alt="" width="25"/><?php echo '1 EUR - ' . number_format(1, 2, '.', ' ') . ' EUR';?></li>
                                <li><img src="../../../img/usd.png" alt="" width="25"/><?php echo '1 EUR - ' . number_format(floatval($rates['EURUSD']), 2) . ' USD';?></li>
                                <li><img src="../../../img/gbp.png" alt="" width="25"/><?php echo '1 EUR - ' . number_format(floatval('0'.$rates['EURGBP']), 2) . ' GBP';?></li>
                            </ul>
                            <input type="button" value="More"/>
                        </div>                     
                    </div>                                   
                </section>
            <footer>
                <div class="content">
                    <section class="footer-content" style="margin-right: 67px;">
                        <h3>Quick Navigation</h3>
                        <ul>
                            <li><a href="" title="">Home</a></li>
                            <li><a href="" title="">About Us</a></li>
                            <li><a href="" title="">Special Offers</a></li>
                            <li><a href="" title="">Rezervation</a></li>
                            <li><a href="" title="">Rental Conditions</a></li>
                            <li><a href="" title="">Partners</a></li>
                            <li><a href="" title="">Contact</a></li>
                        </ul>
                    </section>
                    <section class="footer-content" style="margin-right: 66px;">
                        <h3>Contact</h3>
                        <p> Luni-Vineri: 8-20<br/>
                            Sambata-Duminica: 10-18</br>
                            Contact: 0756 318 976</br>
                            <font style="color : #dbdada;">...........</font>: 0760 489 168</br>
                                   E-mail: office@wildride.ro
                        </p>
                    </section>
                    <section class="footer-content" style="margin-right: 67px;">
                        <h3>Keep in Touch</h3>
                        <ul>
                            <li><a href="" title="">Facebook</a></li>
                            <li><a href="" title="">Twitter</a></li>
                            <li><a href="" title="">Google+</a></li>
                            <li><a href="" title="">YouTube</a></li>
                            <li><a href="" title="">LinkedIn</a></li>
                            <li><a href="" title="">Wikipedia</a></li>
                            <li><a href="" title="">Blog WildRide</a></li>
                        </ul>
                    </section>
                    <section class="footer-content">
                        <h3>Newsletter</h3>
                        <p>Keep up with new offers!</p>
                        <form action="../controllers/newsletter.php" method="post">                            
                            <input type="email" name="email-newsletter" id="email-newsletter" required="required">                             
                            <input type="submit" value="Subscribe"/>
                        </form>
                    </section>
                </div>
            </footer>
            <div id="footer-copyright">
                    Copyright © 2013 WildRide
            </div>             
    </body>
</html>
