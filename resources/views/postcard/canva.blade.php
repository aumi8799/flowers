@extends('layouts.app')

@section('title', 'Kurti atviruką su Canva')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4">🎨 Kurk savo atviruką su Canva 🎨</h2>
    <p class="text-center">Redaguok šį gražų šabloną – įrašyk sveikinimą, keisk spalvas ir atsisiųsk PNG ar PDF failą.</p>

    <div style="position: relative; width: 100%; height: 0; padding-top: 70.9459%;
     padding-bottom: 0; box-shadow: 0 2px 8px 0 rgba(63,69,81,0.16); margin-top: 1.6em; margin-bottom: 0.9em; overflow: hidden;
     border-radius: 8px; will-change: transform;">
      <iframe loading="lazy" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; border: none; padding: 0;margin: 0;"
        src="https://www.canva.com/design/DAGlfB5BlUs/XNOEdxU5TBeT8yvJlruQ_w/view?embed" allowfullscreen="allowfullscreen" allow="fullscreen">
      </iframe>
    </div>

    <p class="text-center mt-4">
        <a href="https://www.canva.com/design/DAGlfB5BlUs/XNOEdxU5TBeT8yvJlruQ_w/view?utm_content=DAGlfB5BlUs&amp;utm_campaign=designshare&amp;utm_medium=embeds&amp;utm_source=link" 
           target="_blank" rel="noopener" class="btn btn-outline-primary">
            Atidaryti Canva atskirame lange
        </a>
    </p>
</div>
@endsection
