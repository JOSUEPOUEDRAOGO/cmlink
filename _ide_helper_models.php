<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models\Academique{
/**
 * @property int $id
 * @property int|null $user_id
 * @property string $nom
 * @property string $prenom
 * @property string $email
 * @property string|null $telephone
 * @property int $filiere_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Recrutement\Candidature> $candidatures
 * @property-read int|null $candidatures_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Recrutement\EtudiantCv> $cvs
 * @property-read int|null $cvs_count
 * @property-read \App\Models\Academique\Filiere $filiere
 * @property-read string $nom_complet
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Recrutement\LettreMotivation> $lettresMotivation
 * @property-read int|null $lettres_motivation_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Etudiant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Etudiant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Etudiant query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Etudiant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Etudiant whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Etudiant whereFiliereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Etudiant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Etudiant whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Etudiant wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Etudiant whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Etudiant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Etudiant whereUserId($value)
 */
	class Etudiant extends \Eloquent {}
}

namespace App\Models\Academique{
/**
 * @property int $id
 * @property string $nom
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Academique\Etudiant> $etudiants
 * @property-read int|null $etudiants_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filiere newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filiere newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filiere query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filiere whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filiere whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filiere whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filiere whereUpdatedAt($value)
 */
	class Filiere extends \Eloquent {}
}

namespace App\Models\Admin{
/**
 * @property int $id
 * @property string $cle
 * @property string|null $valeur
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parametre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parametre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parametre query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parametre whereCle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parametre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parametre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parametre whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parametre whereValeur($value)
 */
	class Parametre extends \Eloquent {}
}

namespace App\Models\Admin{
/**
 * @property int $id
 * @property string $description
 * @property int|null $etudiant_id
 * @property int|null $entreprise_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Entreprise\Entreprise|null $entreprise
 * @property-read \App\Models\Academique\Etudiant|null $etudiant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signalement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signalement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signalement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signalement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signalement whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signalement whereEntrepriseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signalement whereEtudiantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signalement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signalement whereUpdatedAt($value)
 */
	class Signalement extends \Eloquent {}
}

namespace App\Models\Communication{
/**
 * @property int $id
 * @property string $contenu
 * @property int|null $etudiant_id
 * @property int|null $entreprise_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Entreprise\Entreprise|null $entreprise
 * @property-read \App\Models\Academique\Etudiant|null $etudiant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereContenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereEntrepriseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereEtudiantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereUpdatedAt($value)
 */
	class Message extends \Eloquent {}
}

namespace App\Models\Entreprise{
/**
 * @property int $id
 * @property int|null $user_id
 * @property string $nom
 * @property string $email
 * @property string|null $telephone
 * @property string|null $adresse
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Messagerie\Conversation> $conversations
 * @property-read int|null $conversations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Entreprise\Offre> $offres
 * @property-read int|null $offres_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entreprise newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entreprise newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entreprise query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entreprise whereAdresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entreprise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entreprise whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entreprise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entreprise whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entreprise whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entreprise whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entreprise whereUserId($value)
 */
	class Entreprise extends \Eloquent {}
}

namespace App\Models\Entreprise{
/**
 * @property int $id
 * @property string $titre
 * @property string $description
 * @property string $type
 * @property int $entreprise_id
 * @property int|null $categorie_id
 * @property string|null $localisation
 * @property \Illuminate\Support\Carbon|null $date_expiration
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Recrutement\Candidature> $candidatures
 * @property-read int|null $candidatures_count
 * @property-read \App\Models\Referentiel\Categorie|null $categorie
 * @property-read \App\Models\Entreprise\Entreprise $entreprise
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offre query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offre whereCategorieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offre whereDateExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offre whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offre whereEntrepriseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offre whereLocalisation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offre whereTitre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offre whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offre whereUpdatedAt($value)
 */
	class Offre extends \Eloquent {}
}

namespace App\Models\Messagerie{
/**
 * @property int $id
 * @property int|null $etudiant_id
 * @property int|null $entreprise_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Entreprise\Entreprise|null $entreprise
 * @property-read \App\Models\Academique\Etudiant|null $etudiant
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Messagerie\Message> $messages
 * @property-read int|null $messages_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereEntrepriseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereEtudiantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereUpdatedAt($value)
 */
	class Conversation extends \Eloquent {}
}

namespace App\Models\Messagerie{
/**
 * @property int $id
 * @property int $conversation_id
 * @property int $sender_id
 * @property string $message
 * @property bool $is_read
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Messagerie\Conversation $conversation
 * @property-read \App\Models\User $sender
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereConversationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereUpdatedAt($value)
 */
	class Message extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $page
 * @property string $section
 * @property string $key
 * @property string|null $value
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageSection active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageSection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageSection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageSection page($page)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageSection query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageSection section($section)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageSection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageSection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageSection whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageSection whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageSection wherePage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageSection whereSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageSection whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageSection whereValue($value)
 */
	class PageSection extends \Eloquent {}
}

namespace App\Models\Recrutement{
/**
 * @property int $id
 * @property string|null $nom
 * @property string|null $email
 * @property string|null $telephone
 * @property string|null $message
 * @property string|null $cv_path
 * @property int|null $etudiant_id
 * @property int $offre_id
 * @property string $statut
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Academique\Etudiant|null $etudiant
 * @property-read \App\Models\Entreprise\Offre $offre
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature whereCvPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature whereEtudiantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature whereOffreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature whereUpdatedAt($value)
 */
	class Candidature extends \Eloquent {}
}

namespace App\Models\Recrutement{
/**
 * @property int $id
 * @property int $etudiant_id
 * @property string $titre
 * @property string $cv_path
 * @property bool $principal
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Academique\Etudiant $etudiant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EtudiantCv newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EtudiantCv newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EtudiantCv query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EtudiantCv whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EtudiantCv whereCvPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EtudiantCv whereEtudiantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EtudiantCv whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EtudiantCv wherePrincipal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EtudiantCv whereTitre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EtudiantCv whereUpdatedAt($value)
 */
	class EtudiantCv extends \Eloquent {}
}

namespace App\Models\Recrutement{
/**
 * @property int $id
 * @property int $etudiant_id
 * @property string $titre
 * @property string $contenu
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Academique\Etudiant $etudiant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LettreMotivation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LettreMotivation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LettreMotivation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LettreMotivation whereContenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LettreMotivation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LettreMotivation whereEtudiantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LettreMotivation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LettreMotivation whereTitre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LettreMotivation whereUpdatedAt($value)
 */
	class LettreMotivation extends \Eloquent {}
}

namespace App\Models\Referentiel{
/**
 * @property int $id
 * @property string $nom
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Entreprise\Offre> $offres
 * @property-read int|null $offres_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorie query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorie whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorie whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorie whereUpdatedAt($value)
 */
	class Categorie extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int|null $created_by
 * @property string $type
 * @property string $titre
 * @property string|null $motif
 * @property numeric|null $montant
 * @property \Illuminate\Support\Carbon|null $starts_at
 * @property \Illuminate\Support\Carbon|null $ends_at
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sanction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sanction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sanction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sanction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sanction whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sanction whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sanction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sanction whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sanction whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sanction whereMotif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sanction whereStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sanction whereTitre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sanction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sanction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sanction whereUserId($value)
 */
	class Sanction extends \Eloquent {}
}

namespace App\Models{
/**
 * @mixin \Spatie\Permission\Traits\HasRoles
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $account_type
 * @property string $status
 * @property string|null $remember_token
 * @property string|null $bio
 * @property string|null $avatar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Entreprise\Entreprise|null $entreprise
 * @property-read \App\Models\Academique\Etudiant|null $etudiant
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 */
	class User extends \Eloquent {}
}

