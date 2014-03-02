<?php

/**
 * Room UI customization filter.
 *
 * This filter decides if a room requires particular customization.
 *
 * @package    betkup.fr
 * @subpackage room
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: roomUIFilter.class.php 6288 2012-10-22 18:09:32Z anguenot $
 */
class sfRoomUIFilter extends sfFilter
{

    private static $LOG_KEY = "sfRoomUIFilter : ";

    /**
     * Returns the room UUID.
     *
     * The URL pattern is:
     *
     *     /room/view/<uuid>
     *     /room/edit/<uuid>
     *
     * @return int or NULL
     */
    private function getRoomUUID()
    {
        $uuid = -1;
        $uuid = $this->getContext()->getRequest()->getParameter("uuid", -1);
        if ($uuid == -1) {
            // Kup within room
            $uuid = $this->getContext()->getRequest()->getParameter("room_uuid", -1);
        }
        return $uuid;
    }

    /**
     * Returns the Room UI bindings.
     *
     * @return array from room name to yml configuration file.
     */
    private function getRoomUIBindings()
    {
        $cacheKey = 'rooms_ui_bindings';
        $roomsUIBindings = sfMemcache::getInstance()->get($cacheKey, array());
        if (empty($roomsUIBindings)) {
            $config = sfConfig::get('mod_room_ui_bindings');
            $bindings = explode(" ", $config);
            $roomsUIBindings = array();
            foreach ($bindings as $binding) {
                $binding_param = $this->getRoomUIFor($binding);
                $roomName = $binding_param['roomName'];
                $roomsUIBindings[$roomName] = $binding_param;
            }
            if (!empty($roomsUIBindings)) {
                sfMemcache::getInstance()->set($cacheKey, $roomsUIBindings, 0, 0);
            }
        }
        return $roomsUIBindings;
    }

    /**
     * Returns the Room UI parameters given the yaml configuration file.
     *
     * @param str $file
     */
    private function getRoomUIFor($file)
    {
        $module_dir = sfConfig::get('sf_app_module_dir');
        $module_name = 'room';
        $data = 'data/ui';
        $config = sfYaml::load($module_dir . '/' . $module_name . '/' . $data . '/' . $file);
        return $config['ui'];
    }

    /**
     * Returns a room customization given its name.
     *
     * @param str $roomName
     */
    private function getRoomUIParametersFor($roomName)
    {
        $bindings = $this->getRoomUIBindings();
        if (array_key_exists($roomName, $bindings)) {
            return $bindings[$roomName];
        }
        return array();
    }

    public function execute($filterChain)
    {

        // Execute this filter only once
        if ($this->isFirstCall()) {

            // Code to executed before the action execution

            $context = $this->getContext();
            $roomUUID = -1;

            $apply = false;
            $roomUUID = $this->getRoomUUID();
            if ($roomUUID && $roomUUID != -1) {
                $context->getLogger()->info(sfRoomUIFilter::$LOG_KEY . "found room w/ UUID=" . $roomUUID);
                $apply = true;
            }
            if ($apply == true) {
                // Need to get get room from gaming platform since if we are waiting to invoke filter the filter after
                // execution of the action it will be too late for the rendering
                $room = $this->getRoom($this->getContext()->getRequest(), $roomUUID);
                if (count($room) > 0) {
                    $roomName = $room['name'];
                    $uiElements = $this->getRoomUIParametersFor($roomName);
                    if (!empty($uiElements)) {
                        $context->getLogger()->info(
                            sfRoomUIFilter::$LOG_KEY . "found current room data for room w/ name=" . $roomName);
                        $this->getContext()->getRequest()->setAttribute("roomUI", $uiElements);
                    }
                } else {
                    $context->getLogger()->info(sfRoomUIFilter::$LOG_KEY . "Impossible to find room w/ UUID=" . $roomUUID);
                }

            }

            // Execute next filter in the chain
            $filterChain->execute();

            // Nothing to execute after the action execution, before the rendering

        }

    }

    /**
     * Returns a room given its UUID.
     *
     * @param sfWebRequest $request
     * @param int $uuid
     */
    protected function getRoom(sfWebRequest $request, $uuid)
    {

        $room = array();

        $room_uuid = strval($uuid);
        if ($room_uuid == '-1' || $room_uuid == 'me') {
            return $room;
        }

        $cacheKey = 'room_' . $uuid  . "_for_filter_does_not_change";
        $room = sfMemcache::getInstance()->get($cacheKey, array());
        if (empty($room)) {
            $sofun = BetkupWrapper::_getSofunApp($request, $this->getContext());
            try {
                $response = $sofun->api_GET("/team/" . $room_uuid . "/get");
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] == "202") {
                $room = $response['buffer'];
            } else {
                error_log($response['buffer']);
            }
            if (!empty($room)) {
                // Cache it forever. We only care about the actual uuid to name mapping here.
                sfMemcache::getInstance()->set($cacheKey, $room, 0, 0);
            }
        }

        return $room;

    }

}

?>