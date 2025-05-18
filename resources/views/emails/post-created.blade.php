<x-mail::message>
    # Se ha creado un nuevo post que necesita ser aprobado
    <x-mail::panel>
    <p>Post por aprobar:</p>
    </x-mail::panel>

    <x-mail::button :url="route('posts.show', $post)" 
    color="success">
        Click para aprobar
    </x-mail::button>
    
</x-mail::message>