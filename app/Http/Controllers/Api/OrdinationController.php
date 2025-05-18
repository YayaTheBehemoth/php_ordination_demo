<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OrdinationService;
use App\Http\Requests\{
    StorePNRequest,
    StoreDagligFastRequest,
    StoreDagligSkaevRequest,
    AnvendOrdinationRequest
};
use App\Http\Resources\{ 
    PatientResource,
    LaegemiddelResource,
    PNResource,
    DagligFastResource,
    DagligSkaevResource
};

/**
 * @OA\Tag(
 *     name="Ordination",
 *     description="Ordination API endpoints"
 * )
 */
class OrdinationController extends Controller
{
    protected OrdinationService $ordinationService;

    public function __construct(OrdinationService $ordinationService)
    {
        $this->ordinationService = $ordinationService;
    }

    /**
     * @OA\Get(
     *     path="/api/ordination/patienter",
     *     summary="Get all patients",
     *     tags={"Ordination"},
     *     @OA\Response(
     *         response=200,
     *         description="List of patients",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Patient"))
     *     )
     * )
     */
    public function getPatienter()
    {
        return PatientResource::collection($this->ordinationService->getPatienter());
    }

    /**
     * @OA\Get(
     *     path="/api/ordination/laegemidler",
     *     summary="Get all medications",
     *     tags={"Ordination"},
     *     @OA\Response(
     *         response=200,
     *         description="List of medications",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Laegemiddel"))
     *     )
     * )
     */
    public function getLaegemidler()
    {
        return LaegemiddelResource::collection($this->ordinationService->getLaegemidler());
    }

    /**
     * @OA\Get(
     *     path="/api/ordination/anbefalet-dosis/{patientId}/{laegemiddelId}",
     *     summary="Get recommended daily dosage",
     *     tags={"Ordination"},
     *     @OA\Parameter(name="patientId", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="laegemiddelId", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Recommended dosage",
     *         @OA\JsonContent(@OA\Property(property="dosis", type="number", example=0.75))
     *     )
     * )
     */
    public function getAnbefaletDosisPerDoegn($patientId, $laegemiddelId)
    {
        $value = $this->ordinationService->getAnbefaletDosisPerDoegn($patientId, $laegemiddelId);
        return response()->json(['dosis' => $value]);
    }

    /**
     * @OA\Get(
     *     path="/api/ordination/daglig-faste",
     *     summary="Get all DagligFast ordinations",
     *     tags={"Ordination"},
     *     @OA\Response(
     *         response=200,
     *         description="List of DagligFast",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/DagligFast"))
     *     )
     * )
     */
    public function getDagligFaste()
    {
        return DagligFastResource::collection($this->ordinationService->getDagligFaste());
    }

    /**
     * @OA\Get(
     *     path="/api/ordination/daglig-skaeve",
     *     summary="Get all DagligSkaev ordinations",
     *     tags={"Ordination"},
     *     @OA\Response(
     *         response=200,
     *         description="List of DagligSkaev",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/DagligSkaev"))
     *     )
     * )
     */
    public function getDagligSkaeve()
    {
        return DagligSkaevResource::collection($this->ordinationService->getDagligSkaev());
    }

    /**
     * @OA\Get(
     *     path="/api/ordination/pn",
     *     summary="Get all PN ordinations",
     *     tags={"Ordination"},
     *     @OA\Response(
     *         response=200,
     *         description="List of PN ordinations",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/PN"))
     *     )
     * )
     */
    public function getPN()
    {
        return PNResource::collection($this->ordinationService->getPN());
    }

    /**
     * @OA\Get(
     *     path="/api/ordination/stats/{vfra}/{vtil}/{laegemiddelId}",
     *     summary="Get number of ordinations for a medication in a weight range",
     *     tags={"Ordination"},
     *     @OA\Parameter(name="vfra", in="path", required=true, @OA\Schema(type="number")),
     *     @OA\Parameter(name="vtil", in="path", required=true, @OA\Schema(type="number")),
     *     @OA\Parameter(name="laegemiddelId", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Count of relevant ordinations",
     *         @OA\JsonContent(@OA\Property(property="count", type="integer", example=3))
     *     )
     * )
     */
    public function getStats($vfra, $vtil, $laegemiddelId)
    {
        $count = $this->ordinationService->getStats($vfra, $vtil, $laegemiddelId);
        return response()->json(['count' => $count]);
    }

    // --- POST METHODS ---

    /**
     * @OA\Post(
     *     path="/api/ordination/pn",
     *     summary="Create a PN ordination",
     *     tags={"Ordination"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PNRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created PN",
     *         @OA\JsonContent(ref="#/components/schemas/PN")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function opretPN(StorePNRequest $request)
    {
        $data = $request->validated();
        $pn = $this->ordinationService->opretPN(
            $data['patientId'],
            $data['laegemiddelId'],
            $data['antal'],
            $data['startDato'],
            $data['slutDato']
        );

        return (new PNResource($pn))->response()->setStatusCode(201);
    }

    /**
     * @OA\Post(
     *     path="/api/ordination/daglig-fast",
     *     summary="Create a DagligFast ordination",
     *     tags={"Ordination"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/DagligFastRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created DagligFast",
     *         @OA\JsonContent(ref="#/components/schemas/DagligFast")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function opretDagligFast(StoreDagligFastRequest $request)
    {
        $data = $request->validated();
        $fast = $this->ordinationService->opretDagligFast(
            $data['patientId'],
            $data['laegemiddelId'],
            $data['morgen'],
            $data['middag'],
            $data['aften'],
            $data['nat'],
            $data['startDato'],
            $data['slutDato']
        );

        return (new DagligFastResource($fast))->response()->setStatusCode(201);
    }

    /**
     * @OA\Post(
     *     path="/api/ordination/daglig-skaev",
     *     summary="Create a DagligSkaev ordination",
     *     tags={"Ordination"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/DagligSkaevRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created DagligSkaev",
     *         @OA\JsonContent(ref="#/components/schemas/DagligSkaev")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function opretDagligSkaev(StoreDagligSkaevRequest $request)
    {
        $data = $request->validated();
        $skaev = $this->ordinationService->opretDagligSkaev(
            $data['patientId'],
            $data['laegemiddelId'],
            $data['doser'],
            $data['startDato'],
            $data['slutDato']
        );

        return (new DagligSkaevResource($skaev))->response()->setStatusCode(201);
    }

    /**
     * @OA\Post(
     *     path="/api/ordination/anvend",
     *     summary="Mark a PN ordination as used on a specific date",
     *     tags={"Ordination"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AnvendOrdinationRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Result message",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Din anmodning er blevet godkendt, ordinationen kan anvendes"))
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function anvendOrdination(AnvendOrdinationRequest $request)
    {
        $data = $request->validated();
        $response = $this->ordinationService->anvendOrdination(
            $data['pnId'],
            $data['date']
        );
        return response()->json(['message' => $response]);
    }
}