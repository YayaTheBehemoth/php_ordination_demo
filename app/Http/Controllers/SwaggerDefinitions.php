<?php


namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="Ordination API",
 *     version="1.0.0",
 *     description="API documentation for the PHP version of the Ordination project"
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Local API Server"
 * )
 *
 * @OA\Schema(
 *     schema="Patient",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="cprnr", type="string", example="121256-0512"),
 *     @OA\Property(property="navn", type="string", example="Jane Jensen"),
 *     @OA\Property(property="vaegt", type="number", example=63.4)
 * )
 *
 * @OA\Schema(
 *     schema="Laegemiddel",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="navn", type="string", example="Paracetamol"),
 *     @OA\Property(property="enhedPrKgPrDoegnLet", type="number", example=0.1),
 *     @OA\Property(property="enhedPrKgPrDoegnNormal", type="number", example=0.15),
 *     @OA\Property(property="enhedPrKgPrDoegnTung", type="number", example=0.2),
 *     @OA\Property(property="enhed", type="string", example="ml")
 * )
 *
 * @OA\Schema(
 *     schema="Dosis",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="tidspunkt", type="string", example="08:00"),
 *     @OA\Property(property="antal", type="number", example=1.5)
 * )
 *
 * @OA\Schema(
 *     schema="PN",
 *     @OA\Property(property="id", type="integer", example=5),
 *     @OA\Property(property="type", type="string", example="PN"),
 *     @OA\Property(property="start_den", type="string", format="date", example="2024-05-01"),
 *     @OA\Property(property="slut_den", type="string", format="date", example="2024-05-07"),
 *     @OA\Property(property="antal_enheder", type="number", example=2.0),
 *     @OA\Property(property="laegemiddel", ref="#/components/schemas/Laegemiddel"),
 *     @OA\Property(
 *         property="dates",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Dato")
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="DagligFast",
 *     @OA\Property(property="id", type="integer", example=10),
 *     @OA\Property(property="type", type="string", example="DagligFast"),
 *     @OA\Property(property="start_den", type="string", format="date", example="2024-05-01"),
 *     @OA\Property(property="slut_den", type="string", format="date", example="2024-05-07"),
 *     @OA\Property(property="laegemiddel", ref="#/components/schemas/Laegemiddel"),
 *     @OA\Property(property="morgen_dosis", ref="#/components/schemas/Dosis"),
 *     @OA\Property(property="middag_dosis", ref="#/components/schemas/Dosis"),
 *     @OA\Property(property="aften_dosis", ref="#/components/schemas/Dosis"),
 *     @OA\Property(property="nat_dosis", ref="#/components/schemas/Dosis")
 * )
 *
 * @OA\Schema(
 *     schema="DagligSkaev",
 *     @OA\Property(property="id", type="integer", example=12),
 *     @OA\Property(property="type", type="string", example="DagligSkaev"),
 *     @OA\Property(property="start_den", type="string", format="date", example="2024-05-03"),
 *     @OA\Property(property="slut_den", type="string", format="date", example="2024-05-08"),
 *     @OA\Property(property="laegemiddel", ref="#/components/schemas/Laegemiddel"),
 *     @OA\Property(
 *         property="doser",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Dosis")
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="Dato",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="dato", type="string", format="date", example="2024-05-02"),
 *     @OA\Property(property="pn_ordination_id", type="integer", example=5)
 * )
 *
 * @OA\Schema(
 *     schema="PNRequest",
 *     required={"patientId", "laegemiddelId", "antal", "startDato", "slutDato"},
 *     @OA\Property(property="patientId", type="integer", example=1),
 *     @OA\Property(property="laegemiddelId", type="integer", example=2),
 *     @OA\Property(property="antal", type="number", example=2.0),
 *     @OA\Property(property="startDato", type="string", format="date", example="2024-05-01"),
 *     @OA\Property(property="slutDato", type="string", format="date", example="2024-05-07")
 * )
 *
 * @OA\Schema(
 *     schema="DagligFastRequest",
 *     required={"patientId", "laegemiddelId", "morgen", "middag", "aften", "nat", "startDato", "slutDato"},
 *     @OA\Property(property="patientId", type="integer", example=1),
 *     @OA\Property(property="laegemiddelId", type="integer", example=1),
 *     @OA\Property(
 *         property="morgen",
 *         type="object",
 *         required={"tidspunkt","antal"},
 *         @OA\Property(property="tidspunkt", type="string", example="08:00"),
 *         @OA\Property(property="antal", type="number", example=1)
 *     ),
 *     @OA\Property(
 *         property="middag",
 *         type="object",
 *         required={"tidspunkt","antal"},
 *         @OA\Property(property="tidspunkt", type="string", example="12:00"),
 *         @OA\Property(property="antal", type="number", example=1)
 *     ),
 *     @OA\Property(
 *         property="aften",
 *         type="object",
 *         required={"tidspunkt","antal"},
 *         @OA\Property(property="tidspunkt", type="string", example="18:00"),
 *         @OA\Property(property="antal", type="number", example=1)
 *     ),
 *     @OA\Property(
 *         property="nat",
 *         type="object",
 *         required={"tidspunkt","antal"},
 *         @OA\Property(property="tidspunkt", type="string", example="22:00"),
 *         @OA\Property(property="antal", type="number", example=1)
 *     ),
 *     @OA\Property(property="startDato", type="string", format="date", example="2024-05-01"),
 *     @OA\Property(property="slutDato", type="string", format="date", example="2024-05-07")
 * )
 *
 * @OA\Schema(
 *     schema="DagligSkaevRequest",
 *     required={"patientId", "laegemiddelId", "doser", "startDato", "slutDato"},
 *     @OA\Property(property="patientId", type="integer", example=1),
 *     @OA\Property(property="laegemiddelId", type="integer", example=2),
 *     @OA\Property(
 *         property="doser",
 *         type="array",
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(property="tidspunkt", type="string", example="08:00"),
 *             @OA\Property(property="antal", type="number", example=1.0)
 *         )
 *     ),
 *     @OA\Property(property="startDato", type="string", format="date", example="2024-05-01"),
 *     @OA\Property(property="slutDato", type="string", format="date", example="2024-05-07")
 * )
 *
 * @OA\Schema(
 *     schema="AnvendOrdinationRequest",
 *     required={"pnId", "date"},
 *     @OA\Property(property="pnId", type="integer", example=5),
 *     @OA\Property(property="date", type="string", format="date", example="2024-05-03")
 * )
 */
class SwaggerDefinitions {}