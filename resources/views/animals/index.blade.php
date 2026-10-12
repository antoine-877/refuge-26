
<div>
    <h1>Liste des animaux</h1>

    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif

    @if ($animals->isEmpty())
        <p>Aucun animal</p>
    @else
        @foreach ($animals as $animal)
            <article>
                <h2>{{ $animal->name }}</h2>

                <p>
                    Espèce : {{ $animal->species->value }}
                </p>

                <p>
                    Refuge : {{ $animal->shelter->name }}
                </p>

                <p>
                    Âge :
                    @if ($animal->age() !== null)
                        {{ $animal->age() }} ans
                    @else
                        Inconnu
                    @endif
                </p>

                <p>Traits :</p>

                @forelse ($animal->tags as $tag)
                    <span>{{ $tag->name }}</span>
                @empty
                    <span>Aucun trait</span>
                @endforelse

                @if ($animal->isAdopted())
                    <span>Adopté</span>
                @endif

                <p>
                    <a href="{{ route('animals.show', $animal) }}">
                        Voir la fiche
                    </a>
                </p>
            </article>

            <hr>
        @endforeach
    @endif
</div>
