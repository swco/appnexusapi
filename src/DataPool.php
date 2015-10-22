<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI;

class DataPool
{
    /**
     * The number of requests to start throttling requests at
     */
    const THROTTLE_REQUESTS_AT = 80;

    /**
     * @var int Overrides the constant above if set
     */
    private $throttleRequestsAt;

    /**
     * The interval in seconds to measure the throttled requests
     */
    const THROTTLE_REQUEST_INTERVAL_SECONDS = 60;

    /**
     * @param int $throttleRequestsAt
     */
    public function setThrottleRequestsAt($throttleRequestsAt)
    {
        $this->throttleRequestsAt = $throttleRequestsAt;
    }

    /**
     * @return int
     */
    private function getThrottleRequestsAt()
    {
        return $this->throttleRequestsAt ? : self::THROTTLE_REQUESTS_AT;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getAll(Request $request)
    {
        return $this->getData($request);
    }

    /**
     * @param Request $request
     * @param int     $num
     * @param bool    $useOffset
     * @return Response
     */
    public function get(Request $request, $num = -1, $useOffset = false)
    {
        return $this->getData($request, $num, $useOffset);
    }

    /**
     * @param Request $request
     * @param int     $num
     * @param bool    $useOffset
     * @return Response
     */
    private function getData(Request $request, $num = -1, $useOffset = false)
    {
        $offset = 0;

        if ($useOffset) {
            $filter = $request->getFilter();
            $offset = isset($filter['start_element']) ? $filter['start_element'] : $offset;
        }

        $limit = 100;

        return $this->getDataLoop($request, $limit, $offset, $num);
    }

    /**
     * @param Request $request
     * @param int     $limit
     * @param int     $offset
     * @param int     $num
     *
     * @return Response
     * @throws Exceptions\AppNexusAPIException
     * @throws \Exception
     */
    private function getDataLoop(Request $request, $limit, $offset, $num)
    {
        $requestTimes = array();

        do {
            $services = $request->limitBy($limit)->offsetBy($offset)->send();
            $requestTimes[] = time();

            if (!isset($response)) {
                $response = $this->newResponse($services);
            } else {
                $response = $this->appendToResponse($response, $services);
            }

            // If we're not unlimited and we've got everything we wanted, break.
            if ($num !== -1 && $response->getNumElements() >= $num) {
                break;
            }

            $offset += $services->getNumElements();

            // If the offset and limit ends up being bigger than the total that we want then limit it.
            if ($num !== -1 && ($offset + $limit) > $num) {
                $limit = $num - $offset;
            }

            $this->throttleRequests($requestTimes, $request);
        } while ($services->getCount() > $offset);

        return $response;
    }

    /**
     * @param array   $requestTimes
     * @param Request $request
     */
    private function throttleRequests(array &$requestTimes, Request $request)
    {
        if ($this->getThrottleRequestsAt() === count($requestTimes)) {
            $timeTaken = end($requestTimes) - array_shift($requestTimes);
            if (self::THROTTLE_REQUEST_INTERVAL_SECONDS > $timeTaken) {
                $throttleTime = self::THROTTLE_REQUEST_INTERVAL_SECONDS - $timeTaken;

                $request->log("Throttling for $throttleTime seconds");

                sleep($throttleTime);
            }
        }
    }

    /**
     * @param Response $services
     * @return Response
     */
    private function newResponse(Response $services)
    {
        return new Response(
            $services->getArrayCopy(),
            $services->getStatus(),
            $services->getCount(),
            $services->getStartElement()
        );
    }

    /**
     * @param Response $response
     * @param Response $services
     * @return Response
     */
    private function appendToResponse(Response $response, Response $services)
    {
        foreach ($services as $service) {
            $response->append($service);
        }

        $response->setStatus($services->getStatus());

        return $response;
    }
}
