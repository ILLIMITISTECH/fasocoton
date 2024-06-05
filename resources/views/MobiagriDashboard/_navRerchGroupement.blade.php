<div class="container">
    <form action="{{route($pth)}}" method="post">
        @csrf

        @if (Auth::user()->nom_role != 'ca')
        <label>
                
            Mode de filtrage 
            
        </label><hr>
        @endif

        
        <div class="row">
                
            {{-- <div class="col-md-4">
                <div class = "radio">
                    <label>
                        <input type = "radio" name = "optRadio" id = "optRadio" value = "campagne" onclick="btnRadio()" > 
                        Par Campagne
                    </label>
                </div>
            </div> --}}
            @if (Auth::user()->nom_role == 'admin')

            <div class="col-md-6">
                <div class = "radio">
                    <label>
                        <input type = "radio" name = "optRadio" id = "optRadio" value = "zone" onclick="btnRadio()" >
                        Zone
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class = "radio">
                    <label>
                        <input type = "radio" name = "optRadio" id = "optRadio" value = "section" onclick="btnRadio()">
                        Section
                    </label>
                </div>
            </div>

            @elseif(Auth::user()->nom_role != 'ca')
            
            <div class="col-md-6">
                <div class = "radio">
                    <label>
                        <input type = "radio" name = "optRadio" id = "optRadio" value = "section" onclick="btnRadio()">
                        Section
                    </label>
                </div>
            </div>
            @else
             
            {{-- <div class="col-md-6">
                <div class = "radio">
                    <label>
                        <input type = "radio" name = "optRadio" id = "optRadio" value = "section" onclick="btnRadio()">
                        Section
                    </label>
                </div>
            </div>  --}}
            @endif
            
        </div>

        <div class="mt-4"></div>

        <section style="display:none;" id="campagneSearch">

            <div class="row" >
                
                <div class="col-xl-12">
                    <div class="form-group">
                        <label>Sélectionner la campagne:</label>
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
                
                <div class="col-xl-12">
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
        {{-- @php 
            $userRole = Auth::user()->nom_role;
        @endphp
        <input class="form-control" type="hidden" name="userRole" value="{{$userRole}}"> --}}
        @if (Auth::user()->nom_role == 'admin')

            <section style="display:none;" id="allSearch" >

                <div class="row">

                    <div class="col-xl-6">
                        <div class="form-group">
                            <label>Sélectionner la zone :</label>
                            <select style="font-weight: bold;" class="custom-select form-control-border" name='zone' id="zone" >
                            </select>

                        </div>  
                    </div>
                        
                    <div class="col-xl-6">
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

        @elseif(Auth::user()->nom_role == 'ca')
            <section style="display:none;" id="allSearch" >

                <div class="row">
                        
                    <div class="col-xl-12">
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
                    
                <div class="col-xl-12">
                    <div class="form-group">
                        <label>Sélectionner la section :</label>
                        <select style="font-weight: bold;" class="custom-select form-control-border" name='section'  >
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
    
    <br>
</div>


