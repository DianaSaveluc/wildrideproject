<?php require_once("/../models/search.php"); $model = new ModelSearch(); $paginationCount = $model->getPagination($_POST,$count);?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Womics | Adrian Mihaila & Saveluc Diana</title>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <link rel="stylesheet" type="text/css" href="../../../assets/css/main.css" />  
        
        <script type="text/javascript" src="../../../assets/js/jquery-1.9.1.min.js"></script>  
        

        <script type="text/javascript">
            var start_date = '<?php echo $_POST['start-date'];?>';
            var start_adress = '<?php echo $_POST['adress_start'];?>';
            var price_products = null;
            var handles = null;
            
            $(document).ready(function(){
                         
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
            function OrderBy(order){
                if(order.value == "true"){
                    var ascending = false;
                }else{
                    var ascending = true;
                }
                var sorted = $('.results-row').sort(function(a,b){
                    return (ascending ==
                           (convertToNumber($(a).find('.scooter-detailed-price').html()) < 
                            convertToNumber($(b).find('.scooter-detailed-price').html()))) ? 1 : -1;
                }); 

                $('#scooter-list-result').html(sorted);
            }
            var convertToNumber = function(value){
                 return parseFloat(value.replace(' EUR/day',''));
            }
            function ShowPrice(input){
                var txt = document.getElementById('price-filter-text');
                txt.style.display = "block";
                txt.value = input.value;
            }
            function changePagination(pageId,liId){
                  $(".flash").show();
                  $(".flash").fadeIn(400).html('Loading <img src="../../../img/ajax-loading.gif" />');
                  var dataString = 'adress_start=' + start_adress + '&start-date=' + start_date + '&pageId='+ pageId;
                  $.ajax({
                  type: "POST",
                  url: "../controllers/search.php?action=pagination",
                  data: dataString,
                  cache: false,
                  success: function(result){
                           $(".flash").hide();
                           $(".link a").each(function(){
                               $(this).css({ background: "#fff" , color: "#9F9F9F"} );
                           });
                           $("#"+liId+" a").each(function(){
                               $(this).css({ background: "#40AAEB", color: "#fff"}) ;
                           });
                           $("#scooter-list-result").html(result);
                  }
                  });
            }       
            function MakeFilter(pageId,liId,categ,pag_no){
                  $(".flash").show();
                  $(".flash").fadeIn(400).html('Loading <img src="../../../img/ajax-loading.gif" />');
                  if(categ=='price_products'){
                      var add = '&price_products=' + price_products;
                  }else if(categ=='handles_products'){
                      var add = '&handles=' + handles;
                  }else{
                      var add = "";
                  }
                  var dataString = 'adress_start=' + start_adress + '&start-date=' + start_date + '&pageId='+ pageId + '&pag_no=' + pag_no + add;
                  
                  $.ajax({
                  type: "POST",
                  url: "../controllers/search.php?action=filter&category=" + categ,
                  data: dataString,
                  cache: false,
                  success: function(result){
                           $(".flash").hide();  
                           var arr_result = result.split('##');
                           $("#pagination-header-list").html("");
                           $("#pagination-header-list").html('<li class=\'first link\' id="first"><a href="javascript:void(0)" onclick="MakeFilter(\'0\',\'first\',\''+categ+'\',\''+pag_no+'\')">First</a></li>');
                           for(var i=0; i<arr_result[0];i++){
                               $("#pagination-header-list").append('<li id="pag_li_'+ i + '" class=\'link\'><a href="javascript:void(0)" onclick="MakeFilter(\''+ i +'\',\'pag_li_' + i +'\',\''+categ+'\',\''+pag_no+'\')">'+ (i+1) + '</a></li>');
                                           
                           }
                           $("#pagination-header-list").append('<li class=\'last link\'  id="last"><a href="javascript:void(0)" onclick="MakeFilter(\''+ (arr_result[0]-1) +'\',\'last\',\''+categ+'\',\''+pag_no+'\')">Last</a></li><li class="flash"></li>');
                                  
                           
                           $("#pagination-footer-list").html("");
                           $("#pagination-footer-list").html('<li class=\'first link footer-pag\' id="first"><a href="javascript:void(0)" onclick="MakeFilter(\'0\',\'first\',\''+categ+'\',\''+pag_no+'\')">First</a></li>');
                           for(var i=0; i<arr_result[0];i++){
                               $("#pagination-footer-list").append('<li id="pag_li_'+ i + '" class=\'link footer-pag\'><a href="javascript:void(0)" onclick="MakeFilter(\''+ i +'\',\'pag_li_' + i +'\',\''+categ+'\',\''+pag_no+'\')">'+ (i+1) + '</a></li>');
                                           
                           }
                           $("#pagination-footer-list").append('<li class=\'last link footer-pag\'  id="last"><a href="javascript:void(0)" onclick="MakeFilter(\''+ (arr_result[0]-1) +'\',\'last\',\''+categ+'\',\''+pag_no+'\')">Last</a></li><li class="flash"></li>');
                           
                           $(".link a").each(function(){
                               $(this).css({ background: "#fff" , color: "#9F9F9F"} );
                           });
                           $("#"+liId+" a").each(function(){
                               $(this).css({ background: "#40AAEB", color: "#fff"}) ;
                           });
                           $("#scooter-list-result").html(arr_result[1]);
                  }
                  });
            }
        </script> 
    </head>
    <body onload="changePagination('0','first')"> 
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
                        <div id="search-filter">
                            <section id="general-filter">
                                <?php $model->ProductInStock($_POST,$count); ?>
                                <a href="javascript:void(0);" onclick="MakeFilter('0','first','in_stock',<?php echo $count; ?>)">In stock (<?php echo $count;?>)</a>
                                <?php $model->AllProducts($_POST,$count); ?>
                                <a href="javascript:void(0);" onclick="MakeFilter('0','first','all_products',<?php echo $count;?>)">All products (<?php echo $count?>)</a>
                                <?php $model->NewProducts($_POST,$count); ?>
                                <a href="javascript:void(0);" onclick="MakeFilter('0','first','new_products',<?php echo $count;?>)">New products (<?php echo $count?>)</a>
                            </section>
                            <section id="price-filter">
                                <h4>Price (EUR)</h4>
                                <?php $model->PriceProducts($_POST, $min, $max, $range, $count); ?>
                                <input type="range" step="1" name="price-filter" id="price-filter-input" min="<?php echo $min; ?>" max="<?php echo $max; ?>" onchange="rangevalue.value=value; price_products = this.value; MakeFilter('0','first','price_products',<?php echo $count; ?>);"/>
                                <output id="rangevalue"><?php echo $range; ?></output>
                            </section>
                            <section id="handles-filter">
                                <h4>Handles</h4>
                                <?php $model->HandlesProducts($_POST,$rubber,$plastic);?>
                                <input type="checkbox" id="handles-filter-rubber" onchange="$('#handles-filter-plastic').attr('checked', false); handles = 'rubber'; MakeFilter('0','first','handles_products',<?php echo $rubber; ?>);">
                                <label>Rubber (<?php echo $rubber; ?>)</label>
                                <input type="checkbox" id="handles-filter-plastic" onchange="$('#handles-filter-rubber').attr('checked', false); handles = 'plastic'; MakeFilter('0','first','handles_products',<?php echo $plastic; ?>);">
                                <label>Plastic (<?php echo $plastic;?>)</label>
                            </section>
                            <section id="wheels-filter">
                                <h4>Wheels</h4>
                                <?php $model->WheelsProducts($_POST,$aluminum,$iron);?>
                                <input type="checkbox" id="wheels-filter-aluminum">
                                <label>Aluminum(10)</label>
                                <input type="checkbox" id="wheels-filter-iron">
                                <label>Iron(10)</label>
                            </section>
                            <section id="horn-filter">
                                <h4>Horn</h4>
                                <input type="checkbox" id="horn-filter-yes">
                                <label>Yes(10)</label>
                                <input type="checkbox" id="horn-filter-no">
                                <label>No(10)</label>
                            </section>
                        </div>    
                        <div id="search-information">
                            <section id="order-by">
                                <div style="width: 150px; font-size: 12pt;">
                                <select onchange="OrderBy(this);">
                                    <option value="true">Price Asc</option>
                                    <option value="false">Price Desc</option>
                                </select>
                                </div>
                            </section>
                            <div id="scooter-container"></div>
                            <div class="wrapper" id="pagination-header">
                                      <?php
                                        if($count > 0){
                                      ?>
                                      <ul id="pagination-header-list">
                                           <li class='first link' id="first"><a href="javascript:void(0)" onclick="changePagination('0','first')">First</a></li>
                                           <?php
                                           for($i=0;$i<$paginationCount;$i++){
                                              ?><li id="pag_li_<?php echo $i;?>" class='link'><a href="javascript:void(0)" onclick="changePagination('<?php echo $i;?>','pag_li_<?php echo $i;?>')"><?php echo $i+1;?></a></li><?php
                                           }
                                           ?>
                                           <li class='last link'  id="last"><a href="javascript:void(0)" onclick="changePagination('<?php echo $paginationCount-1;?>','last')">Last</a></li>
                                           <li class="flash"></li>
                                      </ul>
                                      <?php } ?>
                            </div>  
                            <section id="scooter-list">
                                <ul id="scooter-list-result">  
                                
                                </ul>
                            </section>
                            <div class="wrapper" id="pagination-footer">
                                      <?php
                                        if($count > 0){
                                      ?>
                                      <ul id="pagination-footer-list">
                                           <li class='first link footer-pag' id="first"><a href="javascript:void(0)" onclick="changePagination('0','first')">First</a></li>
                                           <?php
                                           for($i=0;$i<$paginationCount;$i++){
                                              ?><li id="pag_li_<?php echo $i;?>" class='link footer-pag'><a href="javascript:void(0)" onclick="changePagination('<?php echo $i;?>','pag_li_<?php echo $i;?>')"><?php echo $i+1;?></a></li><?php
                                           }
                                           ?>
                                           <li class='last link footer-pag'  id="last"><a href="javascript:void(0)" onclick="changePagination('<?php echo $paginationCount-1;?>','last')">Last</a></li>
                                           <li class="flash"></li>
                                      </ul>
                                      <?php } ?>
                            </div>    
                        </div>
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
