<?php

namespace Pribumi\BeyondAuth\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModels
 *
 * @package Pribumi\BeyondAuth\Models
 * @version    1.0.0
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2015 - 2016, Pribumi Technology
 * @link       http://pribumitech.com
 */
abstract class BaseModels extends Model
{
    /**
     * [Non-Direct Access Model]
     *
     * Dapatkan seluruh data pada table
     *
     * @return object|mixed
     */
    protected function getKendoFilter($filters, $count = 0)
    {
        $where     = "";
        $intcount  = 0;
        $noend     = false;
        $nobegin   = false;
        $typeField = '';
        $typeValue = '';

        // Do we actually have filters or noi ?
        if (isset($filters['filters'])) {
            $itemcount = count($filters['filters']);

            if ($itemcount == 0) {
                $noend   = true;
                $nobegin = true;
            } elseif ($itemcount == 1) {
                $noend   = true;
                $nobegin = true;
            } elseif ($itemcount > 1) {
                $noend   = false;
                $nobegin = false;
            }

            foreach ($filters['filters'] as $key => $filter) {
                if (isset($filter['field'])) {
                    switch ($filter['operator']) {
                        case 'startswith':
                            $compare = " LIKE ";
                            $field   = '`' . $filter['field'] . '`';
                            $value   = "'" . $filter['value'] . "%' ";
                            break;
                        case 'contains':
                            $compare = " LIKE ";
                            $field   = '`' . $filter['field'] . '`';
                            $value   = " '%" . $filter['value'] . "%' ";
                            break;
                        case 'doesnotcontain':
                            $compare = " NOT LIKE ";
                            $field   = '`' . $filter['field'] . '`';
                            $value   = " '%" . $filter['value'] . "%' ";
                            break;
                        case 'endswith':
                            $compare = " LIKE ";
                            $field   = '`' . $filter['field'] . '`';
                            $value   = "'%" . $filter['value'] . "' ";
                            break;
                        case 'eq':
                            $compare = " = ";
                            $field   = '`' . $filter['field'] . '`';
                            $value   = "'" . $filter['value'] . "'";
                            break;
                        case 'gt':
                            $compare = " > ";
                            $field   = '`' . $filter['field'] . '`';
                            $value   = $filter['value'];
                            break;
                        case 'lt':
                            $compare = " < ";
                            $field   = '`' . $filter['field'] . '`';
                            $value   = $filter['value'];
                            break;
                        case 'gte':
                            $compare = " >= ";
                            $field   = '`' . $filter['field'] . '`';
                            $value   = "'" . $filter['value'] . "'";
                            break;
                        case 'lte':
                            $compare = " <= ";
                            $field   = '`' . $filter['field'] . '`';
                            $value   = "'" . $filter['value'] . "'";
                            break;
                        case 'neq':
                            $compare = " <> ";
                            $field   = '`' . $filter['field'] . '`';
                            $value   = "'" . $filter['value'] . "'";
                            break;
                    }

                    if (isset($filter['type'])) {
                        switch ($filter['type']) {
                            case 'date':
                                $typeField = 'DATE(`' . $filter['field'] . '`)';
                                $typeValue = "DATE('" . $filter['value'] . "')";
                                $field     = '';
                                $value     = '';
                                break;

                            case 'integer':
                                $typeField = '';
                                $typeValue = $filter['value'];
                                $field     = '';
                                $value     = '';
                                break;

                            default:
                                $typeField = '';
                                $typeValue = '';
                                break;
                        }

                    } else {

                        $typeField = '';
                        $typeValue = '';
                    }

                    if ($count == 0 && $intcount == 0) {
                        $before = "";
                        $end    = " " . $filters['logic'] . " ";
                    } elseif ($count > 0 && $intcount == 0) {
                        $before = "";
                        $end    = " " . $filters['logic'] . " ";
                    } else {
                        $before = " " . $filters['logic'] . " ";
                        $end    = "";
                    }

                    $where .= ($nobegin ? "" : $before) . $typeField . $field . $compare . $typeValue . $value . ($noend ? "" : $end);
                    $count++;
                    $intcount++;

                } else {
                    $where .= " ( " . $this->parseFilters($filter, $count) . " )";
                }

                $where = str_replace(" or  or ", " or ", $where);
                $where = str_replace(" and  and ", " and ", $where);
            }
        } else {
            $where = " 1 = 1 ";
        }
        return $where;
    }

    abstract public function findByWhere($field, $value);

}
