<?php

class MySqlDBM {
    public function listSchema() {
        return "SELECT DISTINCT TABLE_SCHEMA FROM information_schema.TABLES";
    }
}