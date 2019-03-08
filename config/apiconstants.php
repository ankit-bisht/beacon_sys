<?php

return [
    'success_code' => 200,
    'status' => [
        'success' => 'success',
        'failure' => 'failure',
    ],
    'success_message' => [
        'nodes_fetched_success_message' => 'Nodes Fetched Successfully!',
        'beacon_saved_success_message' => 'Beacon Saved Sucessfully',
        'beacon_fetched_success_message' => 'Beacon Fetched Successfully',
    ],
    'error_code' => [
        'empty_node_error_code' => 204,
        'SOMETHING_WENT_WRONG_ERROR_CODE' => 450,
        'DATA_NOT_FOUND' => 400,
    ],
    'error_message' => [
        'empty_node_error_message' => 'Could not find your location!',
        'SOMETHING_WENT_WRONG_ERROR_MESSAGE' => 'Something Went Wrong',
        'DATA_NOT_FOUND_MESSAGE' => 'Data Not Found',
    ],
    'reverse_direction' => [
        'North' => 'South',
        'North East' => 'South West',
        'East' => 'West',
        'South East' => 'North West',
        'South' => 'North',
        'South West' => 'North East',
        'West' => 'East',
        'North West' => 'South East',
    ]

];
