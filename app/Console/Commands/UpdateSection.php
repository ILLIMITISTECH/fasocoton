<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;

use Illuminate\Support\Facades\Mail;
use Session;

use App\Action;

use Auth;
  
use App\User;
use App\Agent;
use DB;
use App\Producteur;
use Illuminate\Support\Facades\Http;

use App\Notifications\EscalationAction;
use App\Notifications\EscalationActionResponsable;
use App\Notifications\AlerteEscalation;
use Notification;
use App\Mail\NewDemande;

class UpdateSection extends Command
    {
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = "update:section";
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mise a jour de  l activitée';
    
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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    { 
        
       
        DB::table('intrant_equipements')->where('nom_section', 'ZORGHO')->update(['nom_section' =>  'MOGTEDO']);
        DB::table('producteurs')->where('nom_section', 'ZORGHO')->update(['nom_section' =>  'MOGTEDO']);
        DB::table('parcelles')->where('section', 'ZORGHO')->update(['section' =>  'MOGTEDO']);
        DB::table('scoops')->where('section', 'ZORGHO')->update(['section' =>  'MOGTEDO']);
        
        DB::table('intrant_equipements')->where('nom_section', 'SAWINGA')->update(['nom_section' =>  'BITTOU']);
        DB::table('producteurs')->where('nom_section', 'SAWINGA')->update(['nom_section' =>  'BITTOU']);
        DB::table('parcelles')->where('section', 'SAWINGA')->update(['section' =>  'BITTOU']);
        DB::table('scoops')->where('section', 'SAWINGA')->update(['section' =>  'BITTOU']);
        
        DB::table('intrant_equipements')->where('nom_section', 'BITTOU A')->update(['nom_section' =>  'BITTOU']);
        DB::table('producteurs')->where('nom_section', 'BITTOU A')->update(['nom_section' =>  'BITTOU']);
        DB::table('parcelles')->where('section', 'BITTOU A')->update(['section' =>  'BITTOU']);
        DB::table('scoops')->where('section', 'BITTOU A')->update(['section' =>  'BITTOU']);
        
        DB::table('intrant_equipements')->where('nom_section', 'BANTOUGRI B')->update(['nom_section' =>  'BANTOUGRI A']);
        DB::table('producteurs')->where('nom_section', 'BANTOUGRI B')->update(['nom_section' =>  'BANTOUGRI A']);
        DB::table('parcelles')->where('section', 'BANTOUGRI B')->update(['section' =>  'BANTOUGRI A']);
        DB::table('scoops')->where('section', 'BANTOUGRI B')->update(['section' =>  'BANTOUGRI A']);
        
        DB::table('intrant_equipements')->where('nom_section', 'BINDE')->update(['nom_section' =>  'KAIBO']);
        DB::table('producteurs')->where('nom_section', 'BINDE')->update(['nom_section' =>  'KAIBO']);
        DB::table('parcelles')->where('section', 'BINDE')->update(['section' =>  'KAIBO']);
        DB::table('scoops')->where('section', 'BINDE')->update(['section' =>  'KAIBO']);
        
        DB::table('intrant_equipements')->where('nom_section', 'MOAGA B')->update(['nom_section' =>  'MOAGA A']);
        DB::table('producteurs')->where('nom_section', 'MOAGA B')->update(['nom_section' =>  'MOAGA A']);
        DB::table('parcelles')->where('section', 'MOAGA B')->update(['section' =>  'MOAGA A']);
        DB::table('scoops')->where('section', 'MOAGA B')->update(['section' =>  'MOAGA A']);
        
        DB::table('intrant_equipements')->where('nom_section', 'TENSOBTENGA')->update(['nom_section' =>  'DIALGAYE']);
        DB::table('producteurs')->where('nom_section', 'TENSOBTENGA')->update(['nom_section' =>  'DIALGAYE']);
        DB::table('parcelles')->where('section', 'TENSOBTENGA')->update(['section' =>  'DIALGAYE']);
        DB::table('scoops')->where('section', 'TENSOBTENGA')->update(['section' =>  'DIALGAYE']);
        
        DB::table('intrant_equipements')->where('nom_section', 'KOMBISSIRI')->update(['nom_section' =>  'TOÉCÉ']);
        DB::table('producteurs')->where('nom_section', 'KOMBISSIRI')->update(['nom_section' =>  'TOÉCÉ']);
        DB::table('parcelles')->where('section', 'KOMBISSIRI')->update(['section' =>  'TOÉCÉ']);
        DB::table('scoops')->where('section', 'KOMBISSIRI')->update(['section' =>  'TOÉCÉ']);
        
        DB::table('intrant_equipements')->where('owner_name', 'NAMOANO Camille')->update(['nom_section' =>  'GUIARO 6']);
        DB::table('producteurs')->where('owner_name', 'NAMOANO Camille')->update(['nom_section' =>  'GUIARO 6']);
        DB::table('parcelles')->where('owner_name', 'NAMOANO Camille')->update(['section' =>  'GUIARO 6']);
        DB::table('scoops')->where('owner_name', 'NAMOANO Camille')->update(['section' =>  'GUIARO 6']);
        
        DB::table('intrant_equipements')->where('owner_name', 'namoano_camille')->update(['nom_section' =>  'GUIARO 6']);
        DB::table('producteurs')->where('owner_name', 'namoano_camille')->update(['nom_section' =>  'GUIARO 6']);
        DB::table('parcelles')->where('owner_name', 'namoano_camille')->update(['section' =>  'GUIARO 6']);
        DB::table('scoops')->where('owner_name', 'namoano_camille')->update(['section' =>  'GUIARO 6']);
     
        $this->info('Le Code a été executé');
    }
    
}
