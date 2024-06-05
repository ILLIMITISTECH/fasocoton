<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OPTIEVENT</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="{{asset('public3/fonts/material-icon/css/material-design-iconic-font.min.css')}}">

    <!-- Main css -->
    <link rel="stylesheet" href="{{asset('public3/css/style.css')}}">
</head>
<body>
    <div class="main">

        <section class="signup">
            <!-- <img src="images/signup-bg.jpg" alt=""> -->
            <div class="container">
                <div class="signup-content">
                    <center>@if ($message = Session::get('success'))

<div class="alert alert-success">

    <p>{{ $message }}</p>

</div></center>

@endif


<h6> @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif</h6>

                    <h6> @if (session('messagesss'))
                        <div class="alert alert-success" role="alert">
                            {{ session('messagesss') }}
                        </div>
                    @endif</h6>

                    <h6> @if (session('messages'))
                        <div class="alert alert-success" role="alert">
                            {{ session('messages') }}
                        </div>
                    @endif</h6>
                    
                    <h5> @if (session('message_sugg'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message_sugg') }}
                        </div>
                    @endif</h5>
                    
                     <h5> @if (session('message_suggs'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('message_suggs') }}
                        </div>
                    @endif</h5>
                    
                    
                    
                        <h2 class="form-title" style="color: #4b2E99;"><b>Valider mes suggestions des rendez-vous</b></h2>
                        <br>
                        <div class="card-header" style="font-size:13px;"></b></div>
       <div class="card-body"> 
           <h6>Notre système vous suggere des rendez-vous prioritaires en fonction des informations que vous avez saisies. Merci de confirmer les rendez-vous qui vous
           interessent et de cliquer à chaque fois sur le bouton valider</h6>
           <h6>Vous pouvez accéder à tout moment au catalogue pour voir toutes les entreprises inscrites.</h6>
            <h6 style="color:brown;">Our system suggests priority appointments based on the information you have entered. Please confirm the appointments that you
           interested and each time click on the validate button</h6>
           <h6 style="color:brown;">You can access the catalog at any time to see all the companies registered.</h6>
            @if(count($souhaites) > 2 )
                  <div id="alert success" class="btn btn-success" style="font-size:25px;">Vous ne pouvez valider que 3 souhaits ! Merci </div>
            @else
                        <center>
                    <table class="table ">
                        <thead>
                            
                      <th scope="col">Entreprise</th>
                      <th scope="col">Description entreprise</th>
                      <th scope="col">Partenariat recherché</th>
                      <th scope="col">Etat du rendez-vous</th>
                      <th scope="col">Options</th>
                    </tr>
                  </thead>
                   @foreach($souhaits as $souhait)
                        <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                          >
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <!-- Avatar with inset shadow -->
                          <div
                            class="relative hidden w-8 h-8 mr-3 rounded-full md:block"
                          >
                            <img
                              class="object-cover w-full h-full rounded-full"
                              src="https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&ixid=eyJhcHBfaWQiOjE3Nzg0fQ"
                              alt=""
                              loading="lazy"
                            />
                            <div
                              class="absolute inset-0 rounded-full shadow-inner"
                              aria-hidden="true"
                            ></div>
                          </div>
                          <div>
                            <p class="font-semibold"><a class="" href="{{route('souhaits.show', $souhait->id)}}"> <b  style="color:#4b2e99;">{{$souhait->nom_entreprise}}</b></a></p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                              <b style="color:black;">{{$souhait->pays}}</b><br><a class="btn btn-fill" style="color:white;background-color:#4b2e99;"  href="{{route('souhaits.show', $souhait->id)}}">Details</a>
                            </p>
                          </div>
                        </div>
                      </td>
                      
                      <td class="px-4 py-3 text-sm">
                        {{ substr($souhait->description,0,185) }}
                      </td>
                      
                      <td class="px-4 py-3 text-xs">
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                        >
                          {{$souhait->partenaire_rechercher}}
                        </span>
                      </td>
                      
                      <td class="px-4 py-3 text-sm">
                        @if($souhait->status==0)
                          <div style="color:Red;">Non confirmé</div>
                          @else
                          <div style="color:Green;">Confirmé</div>
                         @endif
                      </td>
                      
                      <!--<td class="px-4 py-3">-->
                      <!--  <div class="flex items-center space-x-4 text-sm">-->
                            
                      <!--    {!! Form::open(['method'=>'post', 'route'=>['status.actif_sugg', $souhait->id]]) !!}-->
                      <!--    <button type="submit" -->
                      <!--      class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"-->
                      <!--      aria-label="Edit"-->
                      <!--    >-->
                      <!--      <svg-->
                      <!--        class="w-5 h-5"-->
                      <!--        aria-hidden="true"-->
                      <!--        fill="currentColor"-->
                      <!--        viewBox="0 0 20 20"-->
                      <!--      >-->
                      <!--        <path-->
                      <!--          d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"-->
                      <!--        ></path>-->
                      <!--      </svg>-->
                      <!--    </button>-->
                      <!--     {!! Form::close() !!}-->
                           
                      <!--     {!! Form::open(['method'=>'post', 'route'=>['status.desactif_sugg', $souhait->id]]) !!}   -->
                      <!--    <button type="submit"-->
                      <!--      class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"-->
                      <!--      aria-label="Delete"-->
                      <!--    >-->
                      <!--      <svg-->
                      <!--        class="w-5 h-5"-->
                      <!--        aria-hidden="true"-->
                      <!--        fill="currentColor"-->
                      <!--        viewBox="0 0 20 20"-->
                      <!--      >-->
                      <!--        <path-->
                      <!--          fill-rule="evenodd"-->
                      <!--          d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"-->
                      <!--          clip-rule="evenodd"-->
                      <!--        ></path>-->
                      <!--      </svg>-->
                      <!--    </button>-->
                      <!--    {!! Form::close() !!}-->
                          
                      <!--  </div>-->
                      <!--</td>-->
                      
                      
                      <td> 
                      {!! Form::open(['method'=>'post', 'route'=>['status.actif_sugg', $souhait->id]]) !!}
                          <button type="submit" 
                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                            aria-label="Edit"
                          >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-plus-fill" viewBox="0 0 16 16">
                                        <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM8.5 6v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 1 0z"/>
                                    </svg>
                                </button>
                           {!! Form::close() !!}
                           
                           
                            
                           {!! Form::open(['method'=>'post', 'route'=>['status.desactif_sugg', $souhait->id]]) !!}   
                          <button type="submit"
                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                            aria-label="Delete"
                          >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                    </svg>  
                                     </button>
                          {!! Form::close() !!}
                                </td>
                      
                      
                    </tr>
                  </tbody>
                   @endforeach
                    </table>  
                        </center>
                    </form>
                </div>
            </div>