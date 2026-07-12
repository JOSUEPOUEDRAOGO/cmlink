@extends('layouts.admin')

@section('content')

<div class="container-fluid">


<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            Utilisateurs
        </h2>

        <p class="text-muted mb-0">
            Gestion des comptes étudiants, entreprises et administrateurs.
        </p>
    </div>


    <a href="{{ route('admin.users.create') }}"
       class="btn btn-primary rounded-pill px-4">

        <i class="bi bi-person-plus me-2"></i>

        Nouvel utilisateur

    </a>


</div>




@if(session('success'))

<div class="alert alert-success rounded-4">
    {{ session('success') }}
</div>

@endif



@if(session('error'))

<div class="alert alert-danger rounded-4">
    {{ session('error') }}
</div>

@endif






{{-- ACTIONS MULTIPLES --}}

<form id="bulkForm"
      method="POST">

@csrf


<div id="bulkActions"
     class="card border-0 shadow-sm rounded-4 mb-3 d-none">


<div class="card-body d-flex align-items-center gap-3">


<strong>
    Actions sélectionnées :
</strong>



<button type="button"
        onclick="bulkDelete()"
        class="btn btn-danger btn-sm rounded-pill">

<i class="bi bi-trash"></i>
Supprimer

</button>



<button type="button"
        onclick="bulkStatus('actif')"
        class="btn btn-success btn-sm rounded-pill">

Activer

</button>



<button type="button"
        onclick="bulkStatus('suspendu')"
        class="btn btn-dark btn-sm rounded-pill">

Suspendre

</button>


</div>


</div>



<div class="card border-0 shadow-sm rounded-4">


<div class="table-responsive">


<table class="table table-hover align-middle mb-0">


<thead class="table-light">


<tr>


<th class="px-4">

<input type="checkbox"
       id="checkAll">

</th>



<th>
Utilisateur
</th>


<th>
Type
</th>


<th>
Rôle
</th>


<th>
Statut
</th>


<th>
Profil lié
</th>


<th>
Date
</th>


<th class="text-center">
Actions
</th>



</tr>


</thead>






<tbody>


@forelse($users as $user)



<tr>


<td class="px-4">

<input type="checkbox"
       class="userCheck"
       name="users[]"
       value="{{ $user->id }}">

</td>





<td>

<div class="fw-semibold">
{{ $user->name }}
</div>

<small class="text-muted">
{{ $user->email }}
</small>

</td>





<td>

<span class="badge bg-light text-dark">

{{ ucfirst($user->account_type) }}

</span>

</td>





<td>

{{ $user->roles->pluck('name')->join(', ') ?: '-' }}

</td>





<td>


@php

$statusClass = match($user->status){

'actif'=>'bg-success',

'refuse'=>'bg-danger',

'suspendu'=>'bg-dark',

default=>'bg-warning text-dark'

};

@endphp



<span class="badge {{ $statusClass }}">

{{ ucfirst(str_replace('_',' ',$user->status)) }}

</span>


</td>







<td>


@if($user->etudiant)

Étudiant :
{{ $user->etudiant->prenom }}
{{ $user->etudiant->nom }}


@elseif($user->entreprise)


Entreprise :
{{ $user->entreprise->nom }}


@else

-

@endif


</td>






<td>

{{ $user->created_at?->format('d/m/Y') }}

</td>







<td class="text-center">


<div class="dropdown">


<button class="btn btn-light border rounded-circle"
data-bs-toggle="dropdown">

<i class="bi bi-three-dots"></i>

</button>




<ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4">



<li>

<a class="dropdown-item"
href="{{ route('admin.users.show',$user) }}">

<i class="bi bi-eye me-2"></i>

Voir détail

</a>

</li>




<li>
<hr class="dropdown-divider">
</li>





<li>

<form method="POST"
action="{{ route('admin.users.destroy',$user) }}">

@csrf
@method('DELETE')


<button class="dropdown-item text-danger"
onclick="return confirm('Supprimer cet utilisateur ?')">


<i class="bi bi-trash me-2"></i>

Supprimer


</button>


</form>


</li>



</ul>


</div>



</td>




</tr>




@empty


<tr>

<td colspan="8"
class="text-center py-5 text-muted">

Aucun utilisateur trouvé.

</td>

</tr>



@endforelse



</tbody>



</table>


</div>





@if($users->hasPages())

<div class="card-footer bg-white border-0">

{{ $users->links() }}

</div>

@endif



</div>


</form>


</div>



<script>


const checkAll =
document.getElementById('checkAll');


const checks =
document.querySelectorAll('.userCheck');


const actions =
document.getElementById('bulkActions');



function updateActions(){

let count =
document.querySelectorAll('.userCheck:checked').length;


if(count > 0){

actions.classList.remove('d-none');

}else{

actions.classList.add('d-none');

}

}





checkAll.addEventListener('change',function(){


checks.forEach(cb=>{

cb.checked=this.checked;

});


updateActions();


});





checks.forEach(cb=>{

cb.addEventListener(
'change',
updateActions
);

});






function bulkDelete(){


if(!confirm(
'Supprimer les utilisateurs sélectionnés ?'
))
return;



let form =
document.getElementById('bulkForm');


form.action =
"{{ route('admin.users.bulkDelete') }}";


form.submit();


}






function bulkStatus(status){


let form =
document.getElementById('bulkForm');


let input =
document.createElement('input');


input.type='hidden';

input.name='status';

input.value=status;


form.appendChild(input);



form.action =
"{{ route('admin.users.bulkStatus') }}";


form.submit();



}



</script>



@endsection
