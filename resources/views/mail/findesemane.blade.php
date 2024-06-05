<!doctype html>

<html>
  <Head></Head>
  <Body>
    <div style="  background: white;   box-sizing: border-box;   color: black;      font-family: Roboto,Arial,sans-serif;   margin: 0 auto;   min-width: 320px;   max-width: 458px;   text-align: center; ">
      <div style=" border: 1px solid #dadce0;   border-radius: 8px;   margin-bottom: 8px;">
        <div style=" padding: 24px 8px;">
       <img src="https://illimitis.collaboratis.com/v2/assets/images/logocollaboratis.png" alt="homepage" class="dark-logo" style="max-width: 80%;"><br><br>
       @if ($params['ma_semaine_total'] >= 50 )
           
          <div style="  font-size: 20px;   font-family: &#39;Google Sans&#39;,Roboto,Arial,sans-serif;   font-weight: 500;   line-height: 28px;   padding: 0 8px 20px; color:black;">“Beau boulot {{$params["user"]->prenom}} ! Votre taux d"exécution est de {{intval($params["ma_semaine_total"])}} % cette semaine”</div>
          <div style="background-image: url(&#39;https://ssl.gstatic.com/search-console/scfe/content/sanmonthlyemail/grail.png&#39;);   background-size: cover;   height: 88px;   margin: 0 auto;   width: 76px;">
            <img src=https://www.google.com/s2/favicons?sz=32&amp;domain=reallygoodemails.com style="  height: 24px;   margin-top: 14px;   width: 24px;">
          </div>
          <br>
      
        <div style=" padding: 24px 16px 32px;">
          
          <div style="font-size:16px;   font-family: &#39;Google Sans&#39;,Roboto,Arial,sans-serif;   line-height: 28px;   padding: 0 8px;color:black">Vous avez clôturé la majorité de vos actions. Nous partageons avec vous le récapitulatif de vos actions en retard. </div>
         <br>
       
        @else 
           
           <div style="  font-size: 20px;   font-family: &#39;Google Sans&#39;,Roboto,Arial,sans-serif;   font-weight: 500;   line-height: 28px;   padding: 0 8px 20px; color:black;"> Attention {{$params["user"]->prenom}} ! Votre taux d"exécution est de {{intval($params["ma_semaine_total"])}} % cette semaine”</div>
            <img width="76" height="88" src="https://cdn-icons-png.flaticon.com/512/1008/1008769.png" alt="" title="" class="loaded">
          </div>
       
      @endif
          <br><br>
         
         
          
          <div style="border: 1px solid #dadce0;   border-radius: 8px;   box-sizing: border-box;   margin: 0 auto 28px;   max-width: 578px;   padding: 16px;">
            <div style="color: black;   display: flex;   font-size: 12px;   letter-spacing: 0.3px;   line-height: 16px;">
              <table>
            <tr> <th><div style=" margin-right: auto;"><b>Libellé</b></div></td>
              <th><div style="max-width:100x; margin-left:200px; "><b>Retard </b></div></td>
               </tr>
            </div>
            <div style=" padding-top: 12px; display: flex;text-align:left;color:black;">
                                                    @php $actions = $params["actions"] ; 
                                                                $nowme = now();
                                                          @endphp
                                                         @foreach($actions as $action)
                                                        
                                                        @if($action->deadline < $nowme) 
                                                            @if($action->pourcentage < 100) 
                                                            @php $cql = intval(abs(strtotime($nowme) - strtotime($action->deadline))/ 86400); @endphp 
                                                            
                                                                 <tr>
                                                                <td>{{$action->libelle}}</td> 
                                                                
                                                                <td>
                                                                <div style="border-radius: 8px;   color: black;   height: 56px;   line-height: 56px;   margin-left:200px;  min-width: 56px;    background: #8ab4f8; ">&emsp;{{$cql}} jrs</div>
                                                                </td>
                                                                
                                                                </tr>
                                                                
                                                          
                                                            @endif
                                                       @endif
                                                        @endforeach
                                                        
                                                      
              
           
         
         
    
     
       </div>
       </table>
       </div></div> 
         <div style="font-size:16px;   font-family: &#39;Google Sans&#39;,Roboto,Arial,sans-serif;   line-height: 28px;   padding: 0 8px;color:black">Excellent week-end !</div>
           <br><br>
            <div>
              <a href="https://illimitis.collaboratis.com" style=" background: #1a73e8;   border-radius: 4px;   color: #ffffff;   display: inline-block;   font-family: &#39;Google Sans&#39;,Roboto,Arial,sans-serif;   font-weight: 500;   letter-spacing: 0.25px;   line-height: 16px;   margin-bottom: 12px;   padding: 10px 24px;   text-decoration: none;" target=_blank>Allez sur collabratis</a>
            </div>
           
    <img height=1 src=https://www.google.com/appserve/mkt/img/AFnwnKUwncdGojxpaQzytvL82kkIIInVwWfgEX7RFtep8KfDcA8.gif width=3>
  </Body>
</html> 