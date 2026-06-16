<?php

namespace App\Events;

use App\Models\Entreprise\Offre;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NouvelleOffrePubliee implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Offre $offre)
    {
        $this->offre->load(['entreprise', 'categorie']);
    }

    public function broadcastOn(): array
    {
        return [new Channel('offres')];
    }

    public function broadcastAs(): string
    {
        return 'nouvelle.offre';
    }

    public function broadcastWith(): array
    {
        return [
            'id'           => $this->offre->id,
            'titre'        => $this->offre->titre,
            'type'         => $this->offre->type,
            'entreprise'   => $this->offre->entreprise->nom ?? '—',
            'localisation' => $this->offre->localisation,
            'categorie_id' => $this->offre->categorie_id,
            'categorie'    => $this->offre->categorie?->nom,
            'url'          => route('front.offres.show', $this->offre),
        ];
    }
}
