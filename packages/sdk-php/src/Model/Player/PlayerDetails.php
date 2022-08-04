<?php

declare(strict_types=1);

namespace SmartpingApi\Model\Player;

use DateTimeImmutable;
use SmartpingApi\Enum\Certificate;
use SmartpingApi\Enum\Gender;
use SmartpingApi\Enum\LicenceCategory;
use SmartpingApi\Enum\LicenceType;
use SmartpingApi\Helper\DateTimeHelpers;
use SmartpingApi\Model\Club\ClubDetail;
use SmartpingApi\Model\SmartpingObject;
use SmartpingApi\Service\ClubAPI;
use Symfony\Component\Serializer\Annotation\SerializedName;

class PlayerDetails extends SmartpingObject
{
    #[SerializedName('idlicence')]
    private int $id;

    #[SerializedName('licence')]
    private string $licence;

    #[SerializedName('nom')]
    private string $lastname;

    #[SerializedName('prenom')]
    private string $firstname;

    #[SerializedName('numclub')]
    private string $clubCode;

    #[SerializedName('nomclub')]
    private string $clubName;

    #[SerializedName('sexe')]
    private Gender $gender;

    #[SerializedName('type')]
    private LicenceType $licenceType;

    #[SerializedName('certif')]
    private Certificate $certificate;

    #[SerializedName('validation')]
    private ?DateTimeImmutable $validatedAt;

    #[SerializedName('echelon')]
    private string $tier;

    #[SerializedName('place')]
    private ?int $place;

    #[SerializedName('point')]
    private float $points;

    #[SerializedName('cat')]
    private LicenceCategory $licenceCategory;

    #[SerializedName('pointm')]
    private float $monthlyPoints;

    #[SerializedName('apointm')]
    private float $previousMonthlyPoints;

    #[SerializedName('initm')]
    private float $startingPoints;

    #[SerializedName('mutation')]
    private ?DateTimeImmutable $mutedAt;

    #[SerializedName('natio')]
    private string $nationality;

    #[SerializedName('arb')]
    private ?string $higherRefereeGrade;

    #[SerializedName('ja')]
    private ?string $higherUmpireGrade;

    #[SerializedName('tech')]
    private ?string $higherTechnicGrade;

    public function __construct(
        string $id,
        string $licence,
        string $lastname,
        string $firstname,
        string $clubCode,
        string $clubName,
        string $gender,
        string $licenceType,
        string $certificate,
        ?string $validatedAt,
        string $tier,
        ?string $place,
        string $points,
        string $licenceCategory,
        string $monthlyPoints,
        string $previousMonthlyPoints,
        string $startingPoints,
        ?string $mutedAt,
        string $nationality,
        ?string $higherRefereeGrade,
        ?string $higherUmpireGrade,
        ?string $higherTechnicGrade
    ) {
        $this->id = empty($id) ? 0 : (int) $id;
        $this->licence = empty($licence) ? '' : $licence;
        $this->lastname = empty($lastname) ? '' : $lastname;
        $this->firstname = empty($firstname) ? '' : $firstname;
        $this->clubCode = empty($clubCode) ? '' : $clubCode;
        $this->clubName = empty($clubName) ? '' : $clubName;
        $this->gender = empty($gender) ? Gender::UNDEFINED : Gender::from($gender);
        $this->licenceType = empty($licenceType) ? LicenceType::UNDEFINED : LicenceType::from($licenceType);
        $this->certificate = empty($certificate) ? Certificate::UNDEFINED : Certificate::from($certificate);
        $this->validatedAt = empty($validatedAt) ? null : DateTimeHelpers::createImmutable($validatedAt, 'd/m/Y');
        $this->tier = empty($tier) ? '' : $tier;
        $this->place = empty($place) ? null : (int) $place;
        $this->points = empty($points) ? 0.0 : (float) $points;
        $this->licenceCategory = empty($licenceCategory) ? LicenceCategory::UNDEFINED : LicenceCategory::from($licenceCategory);
        $this->monthlyPoints = empty($monthlyPoints) ? 0.0 : (float) $monthlyPoints;
        $this->previousMonthlyPoints = empty($previousMonthlyPoints) ? 0.0 : (float) $previousMonthlyPoints;
        $this->startingPoints = empty($startingPoints) ? 0.0 : (float) $startingPoints;
        $this->mutedAt = empty($mutedAt) ? null : DateTimeHelpers::createImmutable($mutedAt, 'd/m/Y');
        $this->nationality = empty($nationality) ? '' : $nationality;
        $this->higherRefereeGrade = empty($higherRefereeGrade) ? null : $higherRefereeGrade;
        $this->higherUmpireGrade = empty($higherUmpireGrade) ? null : $higherUmpireGrade;
        $this->higherTechnicGrade = empty($higherTechnicGrade) ? null : $higherTechnicGrade;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function licence(): string
    {
        return $this->licence;
    }

    public function lastname(): string
    {
        return $this->lastname;
    }

    public function firstname(): string
    {
        return $this->firstname;
    }

    public function clubCode(): string
    {
        return $this->clubCode;
    }

    public function clubName(): string
    {
        return $this->clubName;
    }

    public function club(): ?ClubDetail
    {
        return ClubAPI::getClub($this->clubCode());
    }

    public function gender(): Gender
    {
        return $this->gender;
    }

    public function licenceType(): LicenceType
    {
        return $this->licenceType;
    }

    public function certificate(): Certificate
    {
        return $this->certificate;
    }

    public function validatedAt(): ?DateTimeImmutable
    {
        return $this->validatedAt;
    }

    public function tier(): string
    {
        return $this->tier;
    }

    public function place(): ?int
    {
        return $this->place;
    }

    public function points(): float
    {
        return $this->points;
    }

    public function licenceCategory(): LicenceCategory
    {
        return $this->licenceCategory;
    }

    public function monthlyPoints(): float
    {
        return $this->monthlyPoints;
    }

    public function previousMonthlyPoints(): float
    {
        return $this->previousMonthlyPoints;
    }

    public function startingPoints(): float
    {
        return $this->startingPoints;
    }

    public function mutedAt(): ?DateTimeImmutable
    {
        return $this->mutedAt;
    }

    public function nationality(): string
    {
        return $this->nationality;
    }

    public function higherRefereeGrade(): ?string
    {
        return $this->higherRefereeGrade;
    }

    public function higherUmpireGrade(): ?string
    {
        return $this->higherUmpireGrade;
    }

    public function higherTechnicGrade(): ?string
    {
        return $this->higherTechnicGrade;
    }

    public function monthlyProgression(): float
    {
        return $this->monthlyPoints - $this->previousMonthlyPoints;
    }

    public function yearlyProgression(): float
    {
        return $this->monthlyPoints - $this->startingPoints;
    }

    public function expectedMonthlyProgression(): float
    {
        return $this->points - $this->previousMonthlyPoints;
    }

    public function expectedYearlyProgression(): float
    {
        return $this->points - $this->startingPoints;
    }
}
