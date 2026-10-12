<div>
    <h1>{{ $animal->name }}</h1>

    <p>
        Espèce :
        {{ $animal->species->label() }}
    </p>

    <p>
        Refuge :
        {{ $animal->shelter?->name ?? 'Inconnu' }}
    </p>

    <p>
        Âge :
        @if ($animal->age() !== null)
            {{ $animal->age() }} ans
        @else
            Inconnu
        @endif
    </p>

    <p>Traits de caractère :</p>

    @forelse ($animal->tags as $tag)
        <span>{{ $tag->name }}</span>
    @empty
        <span>Aucun trait</span>
    @endforelse

    @if ($animal->isAdopted())
        <p>Adopté</p>
    @endif

    <p>
        <a href="{{ route('animals.index') }}">
            Retour à la liste
        </a>
    </p>
</div>