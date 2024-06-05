<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Notifications\Messages\MailMessage;

use App\Notifications\BonDebutDeSemaine;
use Notification;

use App\User;
use DB;
use Auth;


class J2 extends Command
{

    use Queueable;  
    /**
     * The name and signature of the console command.
     *
     * @var string  
     */
    //protected $signature = 'command:name';
    protected $signature = 'j2:day';

    /**
     * The console command description.  
     *
     * @var string
     */
    //protected $description = 'Command description';
    protected $description = 'Envoyer un e-mail quotidien à tous les utilisateurs pour un rappel de leurs actions en instance';

    /**
     * Create a new command instance.
     *
     * @return void  
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];  
    }  

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    

    public function handle()
    {
                $dates = date('Y/m/d');

        $users = User::all();
        foreach($users as $user){
            //Auth::login($user);
            //$user->notify(new BonDebutDeSemaine());
                $person = Auth::user();
               
                $modeles = DB::table('modeles')->select('modeles.id', 'modeles.deadline', 'modeles.res_dir', 'modeles.libelle',
                  'modeles.backup', 'modeles.pourcentage','modeles.created_at',
                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'modeles.res_dir')
                    ->whereRaw('? + interval 2 day = modeles.deadline',[$dates])
                    ->where('modeles.res_dir','=', $person->id)
                    ->get();
                    
                $taches = DB::table('tache_modeles')->select('tache_modeles.id', 'tache_modeles.deadline', 'tache_modeles.res_dir', 'tache_modeles.libelle',
                 'tache_modeles.created_at','tache_modeles.statut'
                    )
                    ->whereRaw('? + interval 2 day = tache_modeles.deadline',[$dates])
                    ->where('tache_modeles.res_dir','=', $person->id)
                    ->get();
                    
                $prenom = $user->prenom;
                $to = "$user->email";
                $subject = "Votre activité arrivera à échéance dans 2 jours  !";
                           
                            $body = "
                            <!doctype html><html xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'><head><title>Alerte échéance</title><!--[if !mso]><!-- --><meta http-equiv='X-UA-Compatible' content='IE=edge'><!--<![endif]--><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><meta name='viewport' content='width=device-width,initial-scale=1'><style type='text/css'>#outlook a { padding:0; }
          body { margin:0;padding:0;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%; }
          table, td { border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt; }
          img { border:0;height:auto;line-height:100%; outline:none;text-decoration:none;-ms-interpolation-mode:bicubic; }
          p { display:block;margin:13px 0; }</style><!--[if mso]>
        <xml>
        <o:OfficeDocumentSettings>
          <o:AllowPNG/>
          <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
        </xml>
        <![endif]--><!--[if lte mso 11]>
        <style type='text/css'>
          .mj-outlook-group-fix { width:100% !important; }
        </style>
        <![endif]--><!--[if !mso]><!--><link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet' type='text/css'><style type='text/css'>@import url(https://fonts.googleapis.com/css?family=Poppins);</style><!--<![endif]--><style type='text/css'>@media only screen and (min-width:480px) {
        .mj-column-per-100 { width:100% !important; max-width: 100%; }
      }</style><style type='text/css'>[owa] .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type='text/css'></style></head><body style='background-color:#F4F4F4;'><div style='background-color:#F4F4F4;'><!--[if mso | IE]><table align='center' border='0' cellpadding='0' cellspacing='0' class='' style='width:600px;' width='600' ><tr><td style='line-height:0px;font-size:0px;mso-line-height-rule:exactly;'><![endif]--><div style='background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;'><table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='background:#ffffff;background-color:#ffffff;width:100%;'><tbody><tr><td style='border:0px solid #ffffff;direction:ltr;font-size:0px;padding:20px 0px 0px 0px;padding-bottom:0px;padding-left:0px;padding-right:0px;text-align:center;'><!--[if mso | IE]><table role='presentation' border='0' cellpadding='0' cellspacing='0'><tr><td class='' style='vertical-align:top;width:600px;' ><![endif]--><div class='mj-column-per-100 mj-outlook-group-fix' style='font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;'><table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:top;' width='100%'><tr><td align='left' style='font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;'><div style='font-family:Arial, sans-serif;font-size:18px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;'><p class='text-build-content' data-testid='nu8exbGuE2' style='margin: 10px 0; margin-top: 10px;'><span style='font-family:Poppins;font-size:18px;'><b>Hello $prenom !</b></span></p><p class='text-build-content' data-testid='nu8exbGuE2' style='margin: 10px 0;'><span style='font-family:Poppins;font-size:16px;'>L'activité suivante arrivera à échéance dans 2 jours !</span></p><p class='text-build-content' data-testid='nu8exbGuE2' style='margin: 10px 0; margin-bottom: 10px;'><span style='font-family:Poppins;font-size:16px;'>Tu es invité à prendre toutes les mesures nécessaires à sa finalisation.</span><br>&nbsp;</p></div></td></tr><tr><td style='font-size:0px;padding:10px 25px 10px 25px;padding-right:25px;padding-left:25px;word-break:break-word;'><p style='border-top:solid 2px #000000;font-size:1px;margin:0px auto;width:100%;'></p><!--[if mso | IE]><table align='center' border='0' cellpadding='0' cellspacing='0' style='border-top:solid 2px #000000;font-size:1px;margin:0px auto;width:550px;' role='presentation' width='550px' ><tr><td style='height:0;line-height:0;'> &nbsp;
</td></tr></table><![endif]--></td></tr></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr>
</tbody></table></div><!--[if mso | IE]></td></tr></table>
<table align='center' border='0' cellpadding='0' cellspacing='0' class='' style='width:600px;' width='600' >
<tr>
<td style='line-height:0px;font-size:0px;mso-line-height-rule:exactly;'>
<![endif]-->
<div style='background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;'>
<table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='background:#ffffff;background-color:#ffffff;width:100%;'>
<tbody>
<tr>
<td style='border:0px solid #ffffff;direction:ltr;font-size:0px;padding:0px 0px 0px 0px;padding-bottom:0px;padding-left:0px;padding-right:0px;padding-top:0px;text-align:center;'>
<!--[if mso | IE]><table role='presentation' border='0' cellpadding='0' cellspacing='0'>
<tr><td class='' style='vertical-align:top;width:600px;' >
<![endif]-->
<div class='mj-column-per-100 mj-outlook-group-fix' style='font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;'>
<table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:top;' width='100%'>
<tr><td style='font-size:0px;padding:0px;padding-top:0px;padding-bottom:0px;word-break:break-word;'>
<div style='font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;color:#000000;'>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x' crossorigin='anonymous'>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css'>

<table width='90%' style='margin-top: 20px;'>";

foreach($modeles as $modele)
    {
    if($modele->pourcentage < 100) {
    $body .=" 
  <tr>
    <td class='text-nice'>".$modele->libelle."</td>
    <td class='text-nice'><span class='owner'>".substr($modele->prenom, 0, 1)." ".substr($modele->nom, 0, 1)."</span></td>
    <td><p>&nbsp &nbsp &nbsp</p></td>
    <td class='pourcentage'>".$modele->pourcentage."</td>
    <td class='text-nice'>" .strftime("%d/%m/%Y", strtotime($modele->deadline)). "</td>
    <td><i class='bi bi-chevron-compact-right'></i></td>
  </tr> ";
}
}
   
$body .= "

</table>

<style>.text-nice {
    font-family: 'poppins', sans-serif;
    font-size : 12px;
  }
  
  tr{
    border : 1px solid black;
    
  }
  .owner{
    height : 10px;
    width : 20px;
    text-align : center;
    border: 1px solid #f7b924;
    border-radius: 40px; 
    background: black; 
    color:white;
    font-size: 12px;
    padding : 10%;
    text-shadow: 1px 1px 2px black;
  }
  
  .pourcentage{
    margin-left : 2%;
    padding : 10px;
  }</style></div></td></tr></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr>
  </tbody></table></div><!--[if mso | IE]></td></tr></table>
  <table align='center' border='0' cellpadding='0' cellspacing='0' class='' style='width:600px;' width='600' ><tr><td style='line-height:0px;font-size:0px;mso-line-height-rule:exactly;'>
  <![endif]-->
  <div style='background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;'>
  <table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='background:#ffffff;background-color:#ffffff;width:100%;'>
  <tbody><tr>
  <td style='border:0px solid #ffffff;direction:ltr;font-size:0px;padding:0px 0px 0px 0px;padding-bottom:0px;padding-left:0px;padding-right:0px;padding-top:0px;text-align:center;'>
  <!--[if mso | IE]>
  <table role='presentation' border='0' cellpadding='0' cellspacing='0'><tr>
  <td class='' style='vertical-align:top;width:600px;' ><![endif]-->
  <div class='mj-column-per-100 mj-outlook-group-fix' style='font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;'>
  <table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:top;' width='100%'><tr>
  <td align='left' vertical-align='middle' style='font-size:0px;padding:10px 25px 10px 25px;padding-right:25px;padding-left:25px;word-break:break-word;'>
  <table border='0' cellpadding='0' cellspacing='0' role='presentation' style='border-collapse:separate;line-height:100%;'><tr>
  <td align='center' bgcolor='#000000' role='presentation' style='border:0px solid #ffffff;border-radius:3px;cursor:auto;mso-padding-alt:10px 25px 10px 25px;background:#000000;' valign='middle'>
  <p style='display:inline-block;background:#000000;color:#ffffff;font-family:Arial, sans-serif;font-size:13px;font-weight:normal;line-height:120%;margin:0;text-decoration:none;text-transform:none;padding:10px 25px 10px 25px;mso-padding-alt:0px;border-radius:3px;'>
  <span style='font-family:Poppins;font-size:14px;text-align:left;background-color:#414141;color:#ffffff;'>
  <b>Aller sur Collaboratis</b>
  </span>
  </p></td></tr>
  </table></td></tr></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align='center' border='0' cellpadding='0' cellspacing='0' class='' style='width:600px;' width='600' ><tr><td style='line-height:0px;font-size:0px;mso-line-height-rule:exactly;'><![endif]--><div style='background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;'><table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='background:#ffffff;background-color:#ffffff;width:100%;'><tbody><tr><td style='border:0px solid #ffffff;direction:ltr;font-size:0px;padding:20px 0px 20px 0px;padding-left:0px;padding-right:0px;text-align:center;'><!--[if mso | IE]><table role='presentation' border='0' cellpadding='0' cellspacing='0'><tr><td class='' style='vertical-align:top;width:600px;' ><![endif]--><div class='mj-column-per-100 mj-outlook-group-fix' style='font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;'><table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:top;' width='100%'><tr><td align='left' style='background:#000000;font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-right:25px;padding-bottom:0px;padding-left:25px;word-break:break-word;'><div style='font-family:Arial, sans-serif;font-size:14px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;'><p class='text-build-content' data-testid='FiGIsnfuR' style='margin: 10px 0; margin-top: 10px;'><span style='color:#ffffff;font-family:Poppins;font-size:28px;'><b>Collaboratis .</b></span></p><p class='text-build-content' data-testid='FiGIsnfuR' style='margin: 10px 0;'><span style='color:#ffffff;font-family:Poppins;font-size:14px;'>Made with ❤️ by ILLIMITIS</span></p><p class='text-build-content' data-testid='FiGIsnfuR' style='margin: 10px 0; margin-bottom: 10px;'><span style='color:#ffffff;font-family:Poppins;font-size:14px;'>Tous droits réservés&nbsp;</span></p></div></td></tr></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align='center' border='0' cellpadding='0' cellspacing='0' class='' style='width:600px;' width='600' ><tr><td style='line-height:0px;font-size:0px;mso-line-height-rule:exactly;'><![endif]--><div style='margin:0px auto;max-width:600px;'><table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='width:100%;'><tbody><tr><td style='direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;'><!--[if mso | IE]><table role='presentation' border='0' cellpadding='0' cellspacing='0'><tr><td class='' style='vertical-align:top;width:600px;' ><![endif]--><div class='mj-column-per-100 mj-outlook-group-fix' style='font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;'><table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:top;' width='100%'><tr><td align='left' style='font-size:0px;padding:0px 20px 0px 20px;padding-top:0px;padding-bottom:0px;word-break:break-word;'><div style='font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;'><p style='text-align: center; margin: 10px 0; margin-top: 10px; margin-bottom: 10px;'><span style='line-height:22px;text-align:center;font-size:13px;letter-spacing:normal;text-align:left;color:#55575d;font-family:Arial;'>This e-mail has been sent to [[EMAIL_TO]], <a href='[[UNSUB_LINK_EN]]' style='color:inherit;text-decoration:none;' target='_blank'>click here to unsubscribe</a>.</span></p></div></td></tr><tr><td align='left' style='font-size:0px;padding:0px 20px 0px 20px;padding-top:0px;padding-bottom:0px;word-break:break-word;'><div style='font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;'><p style='text-align: center; margin: 10px 0; margin-top: 10px; margin-bottom: 10px;'><span style='line-height:22px;text-align:center;font-size:13px;letter-spacing:normal;text-align:left;color:#55575d;font-family:Arial;'>   SN</span></p></div></td></tr></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]-->
  </div></body></html> ";
                                
                           $headers = "From: notification.collaboratis@gmail.com" . "\r\n" 
                                            ."CC: fallougueye197@gmail.com /n"
                                            ."Reply-To:notification.collaboratis@gmail.com\n"
                                            ."Content-Type:text/html;charset=\"utf-8\"";
                                            
                           mail($to,$subject,$body,$headers);
                           
                      
                        
                        
                            echo '<br><br><br> <span class="alert alert-success" role="alert" style ="margin-top : 100px; margin-left : 150px; width : 350px;"> Les Mails ont été envoyés avec succès </span>';
                       
            
                     //}       
        }
         
        $this->info('Mail de rappel hebdomadaire envoyé');
    }

}