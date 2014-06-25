<?php

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder_GroupStatement extends Gs_QueryBuilder_Statement
{
    /**
     * Return the resulting query
     * @return string
     */
    public function toSql()
    {
        if ($this->isEmpty()) {
            return '';
        } else {
            return 'GROUP BY ' . implode(', ', $this->getParams());
        }
    }

}
