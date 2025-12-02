@extends('layouts.app')

@section('title', 'Trip-map')

@section('content')
<style>
.big-card, .post-card {
  overflow: hidden;   
  box-shadow: 0 4px 12px var(--shadow);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.post-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 20px var(--shadow);
}

/* .trip-map-page main.py-4 {
    display: flex;
  flex-direction: row;
  height: calc(100vh - 70px);
  width: 100vw;
  padding: 0 !important;
  margin: 0 !important;
  background-color: #E6F4FA;
  overflow: hidden;
} */
html, body {
height: 100%;
  margin: 0;
  padding: 0;
  background-color: #E6F4FA;
  overflow-x: hidden; 
  overflow-y: auto; 
}
p span {
  margin-left: 0.5em;
}

 span{
   color:#CAAE99;
}

 .carousel-item {
  height: 320px; 
}
 .post-image{
    width: 100%; 
    height:320px;
    object-fit:cover;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
 }
.post-col-12{
  padding:0.5rem;
}

.col-md-6{
    padding:0.5rem;
}

.map-container {
    width: 100%;     
  height: 80vh;      
  max-width: 900px; 
  margin: 0 auto;
  position: relative;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #E6F4FA;
}
#map{
  display: block;
  width: 600px;
   height: 660px;
}

#map svg {
  width: 100%;
  height: 100%;
  display: block;
  max-width: none;
}
  path {
    stroke: #333;
    stroke-width: 0.5;
    fill: #ccc;
  }
  path:hover {
    fill: #F1BDB2;
  }

  .spinner-wrapper {
  position: absolute;
  bottom: 5%;
  left: 60%;
  z-index: 10;
}

.spinner-outer {
  position: relative;
  width: 200px;
  height: 200px;
  border-radius: 50%;
  background: transparent;
}

.spinner-circle {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  background: conic-gradient(#F1BDB2 0deg, #FFFF 0deg); 
  transition: background 0.5s ease;
}

.spinner-text {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
}

.spinner-text p {
  margin: 0;
}

.spinner-text .label {
  font-family: 'Source Serif Pro', serif;
  color: #9F6B46;
  font-weight: 600;
  font-size: 25px;
  margin-bottom: 2px;
}

.spinner-text .count {
  font-family: 'Source Serif Pro', serif;
  color: #9F6B46;
  font-weight: bold;
  font-size: 65px;
  line-height: 1;
}
.spinner-text .small-text {
    font-size: 18px;
    color: #CAAE99;
}
.big-card-body{
    height: 75vh;
    overflow-y:auto;
}
.big-card{
   border:0px;
   background-color: #FFFBEB;
   box-shadow: 0 5px 8px rgba(0, 0, 0, 0.4);   
   opacity: 0;
  transition: opacity 0.4s ease;
  display: none;
}

.big-card.show{
    display:block !important;
    opacity:1;
    animation: slideIn 0.4s ease-out;
  }
  @keyframes slideIn{
    from { opaxity: 0; transform:translateX(20px); }
    to { opacity: 1; transform: translateX(0); }
  }

.post-card{
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

@media (max-width: 600px) {
    .trip-map-page main.py-4 {
    flex-direction: column; 
    height: auto;
    overflow: auto;
  }

  /* html, body {
    overflow-y: auto;  
  }  */

  .spinner-wrapper {
    position: absolute;
    bottom: 5%;
    right: 5%;
    transform: translateX(10%) scale(0.6);
  }

.big-card-body {
  padding: 1rem;
  height: auto;         
  overflow-y: visible; 
}

/* .big-card {
  order: 2;
  width: 100%;
  border-radius: 15px 15px  15px 15px; */
  /* overflow-y: visible; 
  max-height: none; 
  background-color: #FFFBEB;
  /* border-radius: 20px; */
  /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  opacity: 0;
  transition: opacity 0.4s ease; */
  /* } */ 

.map-container {
    width: 100%;
    height: 45vh;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  /* #map svg {
    transform-origin: center;
    transform: none; 
    height: 45vh;
  }

  .map{
    display:block;
    width: 100%;
    height: 80vh;
  } */

.spinner-text {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -40%);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0rem;   
  text-align: center;
}

.spinner-text p { 
    margin: 0; 
    padding: 0; 
    line-height: 1; 
} 

.spinner-text .label {
  font-size: 20px;
  line-height: 1;
  margin: 2;
  padding: 0;
}

.post-image{
  height: 382px;
  width:100%;
  object-fit: cover;
}
}

</style>


<div class="container-fluid">
    {{-- Map  --}}
  <div class="row">
    <div class="col" style="width: 50vh; height: 50vh;">
        <p class="fw-bold h2 mt-5 text-center  d-flex justify-content-center flex-wrap-nowrap" style="white-space: nowrap;">{{ __('messages.map.map_title1') }}<span>{{ __('messages.map.map_title2') }}</span></p>
            <div class="map-container">
                 <div id="map" class="map"></div>
                    <div class="spinner-wrapper">
                        <div class="spinner-outer">
                            <div class="spinner-text">
                                <p class="label  p-0 m-0">{{ __('messages.map.completed') }}</p>
                                <p class="count p-0 m-0">0<span style="font-size: 27px">/47</span></p>
                                <p class="small-text">{{ __('messages.map.prefecture') }}</p>
                            </div>
                        </div>
                    </div>
            </div>
    </div>

    {{-- Post --}}
    <div class="col mt-1">
        <div class="card mt-5 big-card">
            <div class="card-header border-0 rounded-1" {{--style="border-radius: 16px 16px 0 0; "--}}>
                <h1 class="fw-bold  d-flex justify-content-center m-0" style="color:#9F6B46;">&nbsp;</h1>
            </div>
            <div class="card-body big-card-body" ></div>
        </div>
    </div> 
  </div>
 </div>
@endsection

@push('scripts')
<script src="{{ asset('js/trip-map.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        tripMap({
            userId: {{ $user->id }},
            prefectures: @json($prefectures)
        });
    });
</script>
@endpush

