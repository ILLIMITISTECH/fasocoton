{{-- @if (isset($filtreRoute)) --}}

    <div class="container">
       
        <form action="{{route($pth)}}" method="post">
           @csrf

            <label>
                Mode de filtrage 
                
            </label><hr>

            
            <div class="row">
                 
                <div class="col-md-4">
                    <div class = "radio">
                        <label>
                            <input type = "radio" name = "optRadio" id = "optRadio" value = "campagne" onclick="btnRadio()" > 
                            Par Campagne
                        </label>
                    </div>
                </div>

                @if (Auth::user()->nom_role == 'admin')
                <div class="col-md-4">
                    <div class = "radio">
                        <label>
                            <input type = "radio" name = "optRadio" id = "optRadio" value = "zone" onclick="btnRadio()" >
                            Par Campagne et Zone
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class = "radio">
                        <label>
                            <input type = "radio" name = "optRadio" id = "optRadio" value = "section" onclick="btnRadio()">
                            Par Campagne, Zone et Section
                        </label>
                    </div>
                </div>
                @elseif (Auth::user()->nom_role != 'ca')
                <div class="col-md-4">
                    <div class = "radio">
                        <label>
                            <input type = "radio" name = "optRadio" id = "optRadio" value = "section" onclick="btnRadio()">
                            Par Section
                        </label>
                    </div>
                </div>
                @else
                @endif

               <!-- <div class="col-md-4">
                    <div class = "radio">
                        <label>
                            <input type = "radio" name = "optRadio" id = "optRadio" value = "scoop" onclick="btnRadio()">
                            Par Scoops
                        </label>
                    </div>
                </div> -->
            </div>

            <div class="mt-4"></div>

            <section style="display:none;" id="campagneSearch">

                <div class="row" >
                    
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label>Sélectionner la campagne :</label>
                            <select style="font-weight: bold;" class="custom-select form-control-border" name='campagne' id="campagne" >
                            </select>
                        </div>  
                    </div>

                    <div class="col-xl-12">
                        <button type="submit" class="btn btn-info float-right" >Filtrer <i class="fas fa-filter"></i></button>  
                    </div>
                </div>

            </section>

            <section style="display:none;" id="campagneRegionSearch">

                <div class="row">
                    
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label>Sélectionner la campagne :</label>
                            <select style="font-weight: bold;" class="custom-select form-control-border" name='campagne' id="campagne" >
                                <option disabled selected>Sélectionner la campagne</option>         
                            </select>
                        </div>  
                    </div>

                    <div class="col-xl-6">
                        <div class="form-group">
                            <label>Sélectionner la zone :</label>
                            <select style="font-weight: bold;" class="custom-select form-control-border" name='zone' >
                            </select>
                        </div>  
                    </div>

                    <div class="col-xl-12">
                        <button type="submit" class="btn btn-info float-right" >Filtrer <i class="fas fa-filter"></i></button>  
                    </div>
                </div>

            </section>

            <section style="display:none;" id="scoopSearch">

                <div class="row" >

                    @if (Auth::user()->nom_role == 'admin')
                    {{-- <input class="form-control" type="hidden" name="zoneScoop" id="zoneScoop" value="{{Auth::user()->nom_role}}"> --}}
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label>Sélectionner la zone :</label>
                            <select style="font-weight: bold;" class="custom-select form-control-border" name='zoneScoop' id="zone" >
                            </select>

                        </div>  
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label>Sélectionner la scoop :</label>
                            <select style="font-weight: bold;" class="custom-select form-control-border" name='scoop' id="scoop" >
                            </select>
                        </div>  
                    </div>
                    @else
                    
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label>Sélectionner la scoop :</label>
                            <select style="font-weight: bold;" class="custom-select form-control-border" name='scoop' id="scoop" >
                            </select>
                        </div>  
                    </div>

                    @endif

                    <div class="col-xl-12">
                        <button type="submit" class="btn btn-info float-right" >Filtrer <i class="fas fa-filter"></i></button>  
                    </div>
                </div>

            </section>

            @if (Auth::user()->nom_role == 'admin')
            <section style="display:none;" id="allSearch" >

                <div class="row">
                    <div class="col-xl-4">
                        <div class="form-group">
                            <label>Sélectionner la campagne :</label>
                            <select style="font-weight: bold;" class="custom-select form-control-border" name='campagne' id="campagne" >                                                        
                            </select>
                        </div>  
                    </div>

                    <div class="col-xl-4">
                        <div class="form-group">
                            <label>Sélectionner la zone :</label>
                            <select style="font-weight: bold;" class="custom-select form-control-border" name='zone' id="zone" >
                            </select>

                        </div>  
                    </div>
                    
                    <div class="col-xl-4">
                        <div class="form-group">
                            <label>Sélectionner la section :</label>
                            <select style="font-weight: bold;" class="custom-select form-control-border" name='section' id="section" >
                            </select>
                        </div>  
                    </div>
                    <div class="col-xl-12">
                        <button type="submit" class="btn btn-info float-right">Filtrer <i class="fas fa-filter"></i></button>  
                    </div>
                </div>
            </section>
            @else
            <section style="display:none;" id="allSearch" >

                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label>Sélectionner la campagne :</label>
                            <select style="font-weight: bold;" class="custom-select form-control-border" name='campagne' id="campagne" >                                                        
                            </select>
                        </div>  
                    </div>
                    
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label>Sélectionner la section :</label>
                            <select style="font-weight: bold;" class="custom-select form-control-border" name='section' >
                                <option selected disabled>Sélectionner la section </option>
                                @foreach ($sections as $item)
                                    <option value="{{$item->section}}">{{$item->section}}</option>
                                @endforeach
                            </select>
                        </div>  
                    </div>
                    <div class="col-xl-12">
                        <button type="submit" class="btn btn-info float-right">Filtrer <i class="fas fa-filter"></i></button>  
                    </div>
                </div>
            </section>
            @endif
        </form>
    </div>
    <br><br>
{{-- @endif --}}


