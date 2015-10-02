<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CF\RuleChains;

/**
 * Description of SQL
 *
 * @author james
 */
class SQL extends Rule {
    public $rule;
    /**
     * Executes the SQL Rule
     */
    public function execute() {
        $stmt = self::getConnection($this->name)->prepare($this->rule);
        switch($this->executeType) {
            case "ROW":
                foreach ($this->input as $key => $value) {
                    $stmt->bindParam(":".$key, $value);
                }
                break;
            case "NONE":
                // Do not bind
                break;
            default:
                // Do not bind
                break;                
        }
        $stmt->execute();
        switch($this->resultType) {
            case "ROW": 
                $row = $stmt->fetch();
                $this->output = isFalse($row)?[]:[ $row ];
                break;
            case "RECORDSET": 
                $this->output = &$stmt;
                break;
            case "NONE":
                $this->output = [];
                break;
            default:
                $this->output = [];
                break;
        }
    }
}
