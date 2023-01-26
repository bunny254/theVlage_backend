<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyRequest;
use App\Http\Resources\PropertyListResource;
use App\Http\Resources\PropertyViewResource;
use App\Models\Image;
use App\Models\Property;
use App\Services\FileService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PropertyController extends Controller
{
    // constructor
    public function __construct()
    {
        $this->authorizeResource(Property::class, 'property');
    }

    // index
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        if (auth()->user()->hasAnyRole('admin', 'master')) {
            $properties = Property::query()->paginate();
        } else {
            $properties = Property::owned()->paginate();
        }
        // $properties = Property::owned()->withTrashed()->paginate();
        return PropertyListResource::collection($properties);
    }

    // store
    public function store(PropertyRequest $request)
    {
        if ($request->hasFile('cover_image')) {
            $cover_image = FileService::uploadImageToCloud($request->file('cover_image'));
        } else {
            $cover_image = null;
        }

        $property = Property::create([
            'listing_type' => $request->listing_type,
            'building_type' => $request->building_type,
            'name' => $request->property_name,
            'unit_size' => $request->unit_size,
            'stay_type' => $request->stay_type,
            'is_furnished' => $request->is_furnished,
            'rent_cost' => $request->rent_cost,
            'utilities_cost' => $request->utilities_cost,
            'deposit_months' => $request->deposit_months,
            'currency' => $request->currency,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'description' => $request->description,
            'amenities' => $request->amenities,
            'services' => $request->services,
            'cover_image' => $cover_image,
            'available_from' => Carbon::createFromFormat('Y-m-d', $request->available_from),
        ]);

        return response()->json([
            'status' => Response::HTTP_CREATED,
            'type' => 'success',
            'message' => 'created',
            'property' => new PropertyListResource($property),
        ], Response::HTTP_CREATED);
    }

    // show
    public function show(Property $property)
    {
        return new PropertyViewResource($property->load(['images']));
    }

    // update
    public function update(PropertyRequest $request, Property $property)
    {
        if ($request->hasFile('cover_image')) {
            FileService::deleteCloudImage($property->cover_image);
            $cover_image = FileService::uploadImageToCloud($request->file('cover_image'));
        } else {
            $cover_image = $property->cover_image;
        }

        $property->update([
            'listing_type' => $request->listing_type,
            'building_type' => $request->building_type,
            'name' => $request->property_name,
            'unit_size' => $request->unit_size,
            'stay_type' => $request->stay_type,
            'is_furnished' => $request->is_furnished,
            'rent_cost' => $request->rent_cost,
            'utilities_cost' => $request->utilities_cost,
            'deposit_months' => $request->deposit_months,
            'currency' => $request->currency,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'description' => $request->description,
            'amenities' => $request->amenities,
            'services' => $request->services,
            'cover_image' => $cover_image,
            'available_from' => Carbon::createFromFormat('Y-m-d', $request->available_from),
        ]);
        return response()->json([
            'status' => Response::HTTP_OK,
            'type' => 'success',
            'message' => 'updated',
            'property' => new PropertyListResource($property),
        ], Response::HTTP_OK);
    }

    // trash
    public function destroy(Property $property)
    {
        $property->delete();
        return response()->json([
            'status' => Response::HTTP_OK, 'type' => 'success', 'message' => 'trashed'
        ], Response::HTTP_OK);
    }

    // restore
    public function restore($property)
    {
        Property::onlyTrashed()->find($property)->restore();
        return response()->json([
            'status' => Response::HTTP_OK, 'type' => 'success', 'message' => 'restored'
        ], Response::HTTP_OK);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function changeCoverImage(Request $request, Property $property)
    {
        $this->authorize('update', $property);

        $request->validate([
            'cover_image' => ['bail', 'required', 'image', 'max:5120']
        ]);

        FileService::deleteCloudImage($property->cover_image);

        $property->update([
            'cover_image' => FileService::uploadImageToCloud($request->file('cover_image'))
        ]);

        return response()->json([
            'status' => Response::HTTP_OK, 'type' => 'success', 'message' => 'updated'
        ], Response::HTTP_OK);
    }

    /**
     * @throws \Throwable
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function uploadImage(Request $request, Property $property)
    {
        $this->authorize('update', $property);

        $request->validate(['images' => ['required']]);

        \DB::beginTransaction();

        try {
            $insertData = [];
            foreach ($request->images as $data) {
                $insertData[] = new Image([
                    // 'caption' => $request->caption,
                    'url' => FileService::uploadImageToCloud($data)
                ]);
            }
            $property->images()->saveMany($insertData);
            \DB::commit();
            return response()->json([
                'status' => Response::HTTP_CREATED, 'type' => 'success', 'message' => 'uploaded'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            // Delete images
            foreach ($insertData as $r) {
                FileService::deleteCloudImage($r->url);
            }
            \DB::rollBack();
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST, 'type' => 'error', 'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
