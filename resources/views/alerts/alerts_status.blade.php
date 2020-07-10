
 @if(session('success'))
 <div class="alert alert-success alert-dismissable fade show" role="alert">
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
     </button>
     {{ session('success') }}
 </div>
@endif

@if(session('error'))
 <div class="alert alert-danger alert-dismissable fade show" role="alert"">
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
     </button>
     {{ session('error') }}
 </div>
@endif


@if($errors->any())
 <div class="alert alert-danger alert-dismissable fade show" role="alert"">
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
     </button>
     <strong>Validar os seguintes campos:</strong>
         <ul>
             @foreach ($errors->all() as $error)
                 <li>{{ $error }}</li> 
             @endforeach
         </ul>
 </div>
@endif