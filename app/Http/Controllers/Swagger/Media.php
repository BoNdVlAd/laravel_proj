<?php

namespace App\Http\Controllers\Swagger;

/**
 *  @OA\Schema (
 *      schema="Media",
 *      type="object",
 *      title="Media",
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          example=22
 *      ),
 *      @OA\Property(
 *          property="gallery_id",
 *          type="integer",
 *          example=4
 *      ),
 *      @OA\Property(
 *          property="filename",
 *          type="string",
 *          example="Screenshot from 2024-08-14 16-17-34.png"
 *      ),
 *      @OA\Property(
 *          property="mime_type",
 *          type="string",
 *          example="image/png"
 *      ),
 *      @OA\Property(
 *          property="size",
 *          type="integer",
 *          example=23423
 *      ),
 *      @OA\Property(
 *          property="url",
 *          type="string",
 *          example="/storage/uploads/RJaDG2plFAlZM4KOYvEdLrsrVCrmfoIGYWf64sLG.png"
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          type="string",
 *          example="2024-08-21T13:40:26.000000Z"
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          type="string",
 *          example="2024-08-21T13:40:26.000000Z"
 *      ),
 * )
 */
class Media
{

}
