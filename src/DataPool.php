<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI;

class DataPool
{
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

        $limit  = 100;

        do {
            $services = $request->limitBy($limit)->offsetBy($offset)->send();

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
        } while ($services->getCount() > $offset);

        return $response;
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
