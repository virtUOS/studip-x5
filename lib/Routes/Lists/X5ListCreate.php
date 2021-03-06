<?php

namespace X5\Routes\Lists;

use Argonauts\JsonApiController;
use Argonauts\Routes\TimestampTrait;
use Argonauts\Routes\ValidationTrait;
use Argonauts\Schemas\Course as CourseSchema;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use X5\Models\X5List;
use X5\Schemas\X5List as X5ListSchema;

class X5Listcreate extends JsonApiController
{
    use ValidationTrait, TimestampTrait;
    public function __invoke(Request $request, Response $response, $args)
    {
        // TODO Authorization
        // if (1 == 2) {
        //     throw new AuthorizationFailedException();
        // }

        $x5list = $this->addX5List($request);

        return $this->getCreatedResponse($x5list);
    }

    protected function validateResourceDocument($json, $data)
    {
        if (!$this->validateResourceObject($json, 'data', X5ListSchema::TYPE)) {
            return 'Missing primary resource object.';
        }

        // Attribute: title
        if (!$title = self::arrayGet($json, 'data.attributes.title', '')
            || !mb_strlen(trim($title))) {
            return '`title` must not be empty.';
        }

        //Attribute: release date
        if (!self::isValidTimestamp(self::arrayGet($json, 'data.attributes.releaseDate', ''))) {
            return '`releaseDate` is not a valid Timestamp. ' . self::arrayGet($json, 'data.attributes.releaseDate', '');
        }

        // Relationship: course
        if (!$this->validateResourceObject($json, 'data.relationships.course', CourseSchema::TYPE)) {
            return 'Missing `course` relationship';
        }
    }

    private function addX5List($request)
    {
        $json = $this->validate($request);

        $title = self::arrayGet($json, 'data.attributes.title');
        $release_date = self::fromISO8601(self::arrayGet($json, 'data.attributes.releaseDate'))->getTimestamp();
        $courseId = self::arrayGet($json, 'data.relationships.course.id');

        return $this->createX5List($title, $release_date, $courseId);
    }

    private function createX5List($title, $release_date, $range_id)
    {
        $currentTime = time();
        return X5List::create(
            [
                'title' => $title,
                'range_id' => $range_id,
                'position' => '0',
                'mkdate' => $currentTime,
                'chdate' => $currentTime,
                'visible' => false,
                'release_date' => $release_date,
            ]
        );
    }
}
