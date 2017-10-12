<?php

if (! function_exists('getRequestTypeId')) {
    function getRequestTypeId($requestType)
    {
        $id  =  Config("asgard.workflow.config.request_types.".$requestType);

        if($id == null){
            throw new \Exception("Request type " .$requestType ." not found");
        }
        else{
            return $id;
        }
    }
}

if (! function_exists('getRequestStatusId')) {
    function getRequestStatusId($requestStatus)
    {
        $id  =  Config("asgard.workflow.config.request_status.".$requestStatus);

        if($id == null){
            throw new \Exception("Request status " .$requestStatus ." not found");
        }
        else{
            return $id;
        }
    }
}


if (! function_exists('getTaskStatusId')) {
    function getTaskStatusId($taskStatus)
    {
        $requestStatus = app(getRepoName('WorkflowStatus','Workflow'))
            ->findByAttributes(['status'=>$taskStatus]);

        if($requestStatus === null){
            throw new \Exception("Task status " .$taskStatus ." not found");
        }

        return $requestStatus->id;
    }
}

if (! function_exists('getWorkflowStatusId')) {
    function getWorkflowStatusId($taskStatus)
    {
        $requestStatus = app(getRepoName('WorkflowStatus','Workflow'))
            ->findByAttributes(['status'=>$taskStatus]);

        if($requestStatus === null){
            throw new \Exception("Task status " .$taskStatus ." not found");
        }

        return $requestStatus->id;
    }
}


if (! function_exists('getRepoName')) {
    function getRepoName($entity,$module)
    {
        $repoName = "Modules\\". ucfirst($module)."\\Repositories\\".ucfirst($entity)."Repository";
        if($repoName == null){
            throw new \Exception("Repo " . $module ."//".$entity ." not found");
        }
        else{
            return $repoName;
        }
    }
}

if (! function_exists('getRepoNameByArray')) {
    function getRepoNameByArray($repoName)
    {
        $array = explode(",",$repoName);
        return getRepoName($array[1],$array[0]);
    }
}

if (! function_exists('getRequestTypeName')) {
    function getRequestTypeName($name)
    {
        return Config('asgard.workflow.config.request_types.'.$name,"");
    }
}

if (! function_exists('getLeaveSessionName')) {
    function getLeaveSessionName($id)
    {
        switch ($id){
            case LEAVE_FIRST_SESSION : return "First Half";
            case LEAVE_SECOND_SESSION : return "Second Half";
            case LEAVE_FULL_DAY : return "Whole Day";
        }

    }
}


