<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class AB_Query.
 */
class AB_Query
{
    // Query type.
    const TYPE_SELECT = 1;

    const TYPE_DELETE = 2;

    // Hydration methods.
    const HYDRATE_NONE = 0;

    const HYDRATE_ENTITY = 1;

    const HYDRATE_ARRAY = 2;

    // Sorting order.
    const ORDER_ASCENDING = 'ASC';

    const ORDER_DESCENDING = 'DESC';

    /** @var integer */
    protected $type = self::TYPE_SELECT;

    /** @var null|string  */
    protected $target = null;

    /** @var array JOINs of query */
    protected $joins = array();

    /** @var array WHERE expressions */
    protected $where = array();

    /** @var array GROUP BY */
    protected $group_by = array();

    /** @var array HAVING */
    protected $having = array();

    /** @var integer Number of rows returned by the SELECT */
    protected $limit = 0;

    /** @var integer Specify the offset of the first row to return */
    protected $offset = 0;

    /** @var string */
    protected $sort_by = null;

    /** @var string */
    protected $order = 'ASC';

    /** @var string */
    protected $index_by = null;

    /** @var string */
    protected $entity;

    /** @var array */
    protected $schema;

    /**
     * Constructor.
     *
     * @param string $entity
     * @param string $default_alias
     */
    public function __construct( $entity, $default_alias = 'r' )
    {
        $this->entity  = $entity;
        $this->schema  = call_user_func( array ( $entity, 'getSchema' ) );
        $this->alias   = $default_alias;
        $this->target  = "`{$default_alias}`.*";
        $this->sort_by = "`{$default_alias}`.`id`";
    }

    /**
     * Return the string representation of the query.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->composeQuery();
    }

    /**
     * Set query type to SELECT and specify fields to be selected.
     *
     * @param string $target
     * @return $this
     */
    public function select( $target = null )
    {
        $this->type   = self::TYPE_SELECT;
        $this->target = $target !== null ? $target : "`{$this->alias}`.*";

        return $this;
    }

    /**
     * Set query type to DELETE and specify target.
     *
     * @param string $target
     * @return $this
     */
    public function delete( $target = null )
    {
        $this->type = self::TYPE_DELETE;
        $this->target = $target !== null ? $target : "`{$this->alias}`";

        return $this;
    }

    /**
     * Left join another entity.
     *
     * @param string $entity
     * @param string $alias
     * @param string $on
     * @return $this
     */
    public function leftJoin( $entity, $alias, $on )
    {
        $this->joins[ $alias ] = array(
            'entity' => $entity,
            'table'  => call_user_func( array( $entity, 'getTableName' ) ),
            'schema' => call_user_func( array( $entity, 'getSchema' ) ),
            'on'     => $on,
            'type'   => 'LEFT'
        );

        return $this;
    }

    /**
     * Left join no AB_Entity table.
     *
     * @param string $table
     * @param string $alias
     * @param string $on
     * @return $this
     */
    public function tableJoin( $table, $alias, $on )
    {
        $this->joins[ $alias ] = array(
            'entity' => null,
            'table'  => $table,
            'schema' => null,
            'on'     => $on,
            'type'   => 'LEFT'
        );

        return $this;
    }

    /**
     * Inner join another entity.
     *
     * @param string $entity
     * @param string $alias
     * @param string $on
     * @return $this
     */
    public function innerJoin( $entity, $alias, $on )
    {
        $this->joins[ $alias ] = array(
            'entity' => $entity,
            'table'  => call_user_func( array( $entity, 'getTableName' ) ),
            'schema' => call_user_func( array( $entity, 'getSchema' ) ),
            'on'     => $on,
            'type'   => 'INNER'
        );

        return $this;
    }

    /**
     * Set the maximum number of results to return at once.
     *
     * @param  integer $limit
     * @return self
     */
    public function limit( $limit )
    {
        $this->limit = (int) $limit;

        return $this;
    }

    /**
     * Set the offset to use when calculating results.
     *
     * @param  integer $offset
     * @return self
     */
    public function offset( $offset )
    {
        $this->offset = (int) $offset;

        return $this;
    }

    /**
     * Set the column we should sort by.
     *
     * @param  string $sort_by
     * @return self
     */
    public function sortBy( $sort_by )
    {
        $this->sort_by = $sort_by;

        return $this;
    }

    /**
     * Set the order we should sort by.
     *
     * @param  string $order
     * @return self
     */
    public function order( $order )
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Add a `=` clause to the search query.
     *
     * @param  string $column
     * @param  string $value
     * @param  string $glue
     * @return self
     */
    public function where( $column, $value, $glue = 'AND' )
    {
        $this->where[] = array( 'type' => 'where', 'column' => $column, 'value' => $value, 'glue' => $glue );

        return $this;
    }

    /**
     * Add a `!=` clause to the search query.
     *
     * @param  string $column
     * @param  string $value
     * @param  string $glue
     * @return self
     */
    public function whereNot( $column, $value, $glue = 'AND' )
    {
        $this->where[] = array( 'type' => 'not', 'column' => $column, 'value' => $value, 'glue' => $glue );

        return $this;
    }

    /**
     * Add a `LIKE` clause to the search query.
     *
     * @param  string $column
     * @param  string $value
     * @param  string $glue
     * @return self
     */
    public function whereLike( $column, $value, $glue = 'AND' )
    {
        $this->where[] = array( 'type' => 'like', 'column' => $column, 'value' => $value, 'glue' => $glue );

        return $this;
    }

    /**
     * Add a `NOT LIKE` clause to the search query.
     *
     * @param  string $column
     * @param  string $value
     * @param  string $glue
     * @return self
     */
    public function whereNotLike( $column, $value, $glue = 'AND' )
    {
        $this->where[] = array( 'type' => 'not_like', 'column' => $column, 'value' => $value, 'glue' => $glue );

        return $this;
    }

    /**
     * Add a `<` clause to the search query.
     *
     * @param  string $column
     * @param  string $value
     * @param  string $glue
     * @return self
     */
    public function whereLt( $column, $value, $glue = 'AND' )
    {
        $this->where[] = array( 'type' => 'lt', 'column' => $column, 'value' => $value, 'glue' => $glue );

        return $this;
    }

    /**
     * Add a `<=` clause to the search query.
     *
     * @param  string $column
     * @param  string $value
     * @param  string $glue
     * @return self
     */
    public function whereLte( $column, $value, $glue = 'AND' )
    {
        $this->where[] = array( 'type' => 'lte', 'column' => $column, 'value' => $value, 'glue' => $glue );

        return $this;
    }

    /**
     * Add a `>` clause to the search query.
     *
     * @param  string $column
     * @param  string $value
     * @param  string $glue
     * @return self
     */
    public function whereGt( $column, $value, $glue = 'AND' )
    {
        $this->where[] = array( 'type' => 'gt', 'column' => $column, 'value' => $value, 'glue' => $glue );

        return $this;
    }

    /**
     * Add a `>=` clause to the search query.
     *
     * @param  string $column
     * @param  string $value
     * @param  string $glue
     * @return self
     */
    public function whereGte( $column, $value, $glue = 'AND' )
    {
        $this->where[] = array( 'type' => 'gte', 'column' => $column, 'value' => $value, 'glue' => $glue );

        return $this;
    }

    /**
     * Add an `IN` clause to the search query.
     *
     * @param  string $column
     * @param  array  $in
     * @param  string $glue
     * @return self
     */
    public function whereIn( $column, array $in, $glue = 'AND' )
    {
        $this->where[] = array( 'type' => 'in', 'column' => $column, 'value' => $in, 'glue' => $glue );

        return $this;
    }

    /**
     * Add a `NOT IN` clause to the search query.
     *
     * @param  string $column
     * @param  array  $not_in
     * @param  string $glue
     * @return self
     */
    public function whereNotIn( $column, array $not_in, $glue = 'AND' )
    {
        $this->where[] = array( 'type' => 'not_in', 'column' => $column, 'value' => $not_in, 'glue' => $glue );

        return $this;
    }

    /**
     * Add an OR statement to the where clause (e.g. (var = foo OR var = bar OR
     * var = baz)).
     *
     * @param  array $where
     * @param  string $glue
     * @return self
     */
    public function whereAny( array $where, $glue = 'AND' )
    {
        $this->where[] = array( 'type' => 'any', 'where' => $where, 'glue' => $glue );

        return $this;
    }

    /**
     * Add an AND statement to the where clause (e.g. (var1 = foo AND var2 = bar
     * AND var3 = baz)).
     *
     * @param  array $where
     * @param  string $glue
     * @return self
     */
    public function whereAll( array $where, $glue = 'AND' )
    {
        $this->where[] = array( 'type' => 'all', 'where' => $where, 'glue' => $glue );

        return $this;
    }

    /**
     * Add a BETWEEN statement to the where clause.
     *
     * @param  string $column
     * @param  string $start
     * @param  string $end
     * @param  string $glue
     * @return $this
     */
    public function whereBetween( $column, $start, $end, $glue = 'AND' )
    {
        $this->where[] = array( 'type' => 'between', 'column' => $column, 'start' => $start, 'end' => $end, 'glue' => $glue );

        return $this;
    }

    /**
     * Add raw where statement.
     *
     * @param  string $statement
     * @param  array  $values
     * @param  string $glue
     * @return self
     */
    public function whereRaw( $statement, array $values, $glue = 'AND' )
    {
        $this->where[] = array( 'type' => 'raw_where', 'statement' => $statement, 'values' => $values, 'glue' => $glue );

        return $this;
    }

    /**
     * Set the group by.
     *
     * @param $column
     *
     * @return $this
     */
    public function groupBy( $column )
    {
        $this->group_by[] = $column;

        return $this;
    }

    /**
     * Add raw having statement.
     *
     * @param  string $statement
     * @param  array  $values
     * @param  string $glue
     * @return self
     */
    public function havingRaw( $statement, array $values, $glue = 'AND' )
    {
        $this->having[] = array( 'type' => 'raw_having', 'statement' => $statement, 'values' => $values, 'glue' => $glue );

        return $this;
    }

    /**
     * Set a column that will be used as index for resulting array.
     *
     * @param string $column
     * @return self
     */
    public function indexBy( $column )
    {
        $this->index_by = $column;

        return $this;
    }

    /**
     * Runs the same query as find, but with no limit and don't retrieve the
     * results, just the total items found.
     *
     * @return integer
     */
    public function count()
    {
        global $wpdb;

        return (int) $wpdb->get_var( $this->composeQuery( true ) );
    }

    /**
     * Compose & execute our query.
     *
     * @param int $hydrate
     * @return array|false|int
     */
    public function execute( $hydrate = self::HYDRATE_NONE )
    {
        global $wpdb;

        // Query
        $query = $this->composeQuery( false );

        switch ( $hydrate ) {
            // DELETE or UPDATE.
            case self::HYDRATE_NONE:
                return $wpdb->query( $query );

            // SELECT.
            case self::HYDRATE_ENTITY:
            case self::HYDRATE_ARRAY:
            default:
                $results = $wpdb->get_results( $query, ARRAY_A );
                if ( $results && ( $hydrate == self::HYDRATE_ENTITY || $this->index_by !== null ) ) {
                    $entity   = $this->entity;
                    $results2 = array();
                    foreach ( $results as $index => $result ) {
                        $i = $this->index_by !== null ? $result[ $this->index_by ] : $index;
                        if ( $hydrate == self::HYDRATE_ENTITY ) {
                            $results2[ $i ] = new $entity();
                            $results2[ $i ]->setFields( $result, true );
                        } else {
                            $results2[ $i ] = $result;
                        }
                    }

                    return $results2;
                }

                return $results;
        }
    }

    /**
     * Execute query and hydrate result as array.
     *
     * @return array
     */
    public function fetchArray()
    {
        return $this->execute( self::HYDRATE_ARRAY );
    }

    /**
     * Execute query and fetch one result as array.
     *
     * @return mixed
     */
    public function fetchRow()
    {
        global $wpdb;

        return $wpdb->get_row( $this->composeQuery( false ), ARRAY_A );
    }

    /**
     * Execute query and hydrate result as entity.
     *
     * @return array
     */
    public function find()
    {
        return $this->execute( self::HYDRATE_ENTITY );
    }

    /**
     * Execute query and fetch one result.
     *
     * @return mixed
     */
    public function findOne()
    {
        $result = $this->fetchRow();

        if ( $result ) {
            $entity = $this->entity;
            $object = new $entity();
            $object->setFields( $result, true );
            $result = $object;
        }

        return $result;
    }

    /**
     * Compose the actual SQL query from all of our filters and options.
     *
     * @param  boolean $only_count Whether to only return the row count
     * @return string
     */
    public function composeQuery( $only_count = false )
    {
        /** @var AB_Entity $entity */
        $entity = $this->entity;
        $table  = $entity::getTableName();
        $join   = '';
        $where  = '';
        $group  = '';
        $having = '';
        $order  = '';
        $limit  = '';
        $offset = '';
        $values = array();

        // Join.
        foreach ( $this->joins as $alias => $t ) {
            $join .= " {$t['type']} JOIN `{$t['table']}` AS `{$alias}` ON {$t['on']}";
        }

        // Where
        foreach ( $this->where as $q ) {
            // where
            if ( $q['type'] == 'where' ) {
                list ( $field, $format ) = $this->_normalize( $q['column'] );
                $where .= " {$q['glue']} {$field} ";
                if ( $q['value'] == null ) {
                    $where .= 'IS NULL';
                } else {
                    $where .= "= {$format}";
                    $values[] = $q['value'];
                }
            } // where_not
            elseif ( $q['type'] == 'not' ) {
                list ( $field, $format ) = $this->_normalize( $q['column'] );
                $where .= " {$q['glue']} {$field} ";
                if ( $q['value'] == null ) {
                    $where .= 'IS NOT NULL';
                } else {
                    $where .= "!= {$format}";
                    $values[] = $q['value'];
                }
            } // where_like
            elseif ( $q['type'] == 'like' ) {
                list ( $field, $format ) = $this->_normalize( $q['column'] );
                $where .= " {$q['glue']} {$field} LIKE {$format}";
                $values[] = $q['value'];
            } // where_not_like
            elseif ( $q['type'] == 'not_like' ) {
                list ( $field, $format ) = $this->_normalize( $q['column'] );
                $where .= " {$q['glue']} {$field} NOT LIKE {$format}";
                $values[] = $q['value'];
            } // where_lt
            elseif ( $q['type'] == 'lt' ) {
                list ( $field, $format ) = $this->_normalize( $q['column'] );
                $where .= " {$q['glue']} {$field} < {$format}";
                $values[] = $q['value'];
            } // where_lte
            elseif ( $q['type'] == 'lte' ) {
                list ( $field, $format ) = $this->_normalize( $q['column'] );
                $where .= " {$q['glue']} {$field} <= {$format}";
                $values[] = $q['value'];
            } // where_gt
            elseif ( $q['type'] == 'gt' ) {
                list ( $field, $format ) = $this->_normalize( $q['column'] );
                $where .= " {$q['glue']} {$field} > {$format}";
                $values[] = $q['value'];
            } // where_gte
            elseif ( $q['type'] == 'gte' ) {
                list ( $field, $format ) = $this->_normalize( $q['column'] );
                $where .= " {$q['glue']} {$field} >= {$format}";
                $values[] = $q['value'];
            } // where_in
            elseif ( $q['type'] == 'in' ) {
                list ( $field, $format ) = $this->_normalize( $q['column'] );
                $where .= " {$q['glue']} {$field} IN (";

                foreach ( $q['value'] as $value ) {
                    $where .= "{$format},";
                    $values[] = $value;
                }

                $where = substr( $where, 0, - 1 ) . ')';
            } // where_not_in
            elseif ( $q['type'] == 'not_in' ) {
                list ( $field, $format ) = $this->_normalize( $q['column'] );
                $where .= " {$q['glue']} {$field} NOT IN (";

                foreach ( $q['value'] as $value ) {
                    $where .= "{$format},";
                    $values[] = $value;
                }

                $where = substr( $where, 0, - 1 ) . ')';
            } // where_any
            elseif ( $q['type'] == 'any' ) {
                $where .= " {$q['glue']} (";

                foreach ( $q['where'] as $column => $value ) {
                    list ( $field, $format ) = $this->_normalize( $column );
                    $where .= "{$field} = {$format} OR ";
                    $values[] = $value;
                }

                $where = substr( $where, 0, - 4 ) . ')';
            } // where_all
            elseif ( $q['type'] == 'all' ) {
                $where .= " {$q['glue']} (";

                foreach ( $q['where'] as $column => $value ) {
                    list ( $field, $format ) = $this->_normalize( $column );
                    $where .= "{$field} = {$format} AND ";
                    $values[] = $value;
                }

                $where = substr( $where, 0, - 5 ) . ')';
            } // between
            elseif ( $q['type'] == 'between' ) {
                list ( $field, $format ) = $this->_normalize( $q['column'] );
                $where .= " {$q['glue']} {$field} BETWEEN {$format} AND {$format}";
                $values[] = $q['start'];
                $values[] = $q['end'];
            } // raw_where
            elseif ( $q['type'] == 'raw_where' ) {
                $where .= " {$q['glue']} ({$q['statement']})";
                foreach ( $q['values'] as $value ) {
                    $values[] = $value;
                }
            }
        }

        // Finish where clause
        if ( ! empty( $where ) ) {
            $where = ' WHERE ' . substr( $where, strpos( $where, ' ', 1 ) + 1 );
        }

        // Group
        if ( ! empty ( $this->group_by ) ) {
            $group = ' GROUP BY ' . implode( ',', $this->group_by );
        }

        // Having
        foreach ( $this->having as $q ) {
            // raw_having
            if ( $q['type'] == 'raw_having' ) {
                $having .= " {$q['glue']} ({$q['statement']})";
                foreach ( $q['values'] as $value ) {
                    $values[] = $value;
                }
            }
        }

        // Finish having clause
        if ( ! empty( $having ) ) {
            $having = ' HAVING ' . substr( $having, strpos( $having, ' ', 1 ) + 1 );
        }

        // Order
        $order = ' ORDER BY ' . $this->sort_by . ' ' . $this->order;

        // Limit
        if ( $this->limit > 0 ) {
            $limit = ' LIMIT ' . $this->limit;
        }

        // Offset
        if ( $this->offset > 0 ) {
            $offset = ' OFFSET ' . $this->offset;
        }

        // Query
        if ( $only_count ) {
            return $this->prepare( "SELECT COUNT(*) FROM `{$table}` AS `{$this->alias}`{$join}{$where}{$group}{$having}", $values );
        }

        switch ( $this->type ) {
            case self::TYPE_DELETE:
                return $this->prepare( "DELETE {$this->target} FROM `{$table}` AS `{$this->alias}`{$join}{$where}", $values );
            case self::TYPE_SELECT:
            default:
                return $this->prepare( "SELECT {$this->target} FROM `{$table}` AS `{$this->alias}`{$join}{$where}{$group}{$having}{$order}{$limit}{$offset}", $values );
        }
    }

    public static function escape( $string )
    {
        global $wpdb;

        return $wpdb->_real_escape( $string );
    }

    /**
     * Prepare query with $wpdb->prepare when there are arguments.
     *
     * @param $query
     * @param $args
     *
     * @return false|null|string
     */
    private function prepare( $query, $args )
    {
        global $wpdb;

        return empty ( $args ) ? $query : $wpdb->prepare( $query, $args );
    }

    /**
     * Get statement and format for column.
     *
     * @param string $column
     * @return array
     * @throws Exception
     */
    private function _normalize( $column )
    {
        $func   = null;
        $alias  = null;
        $field  = null;
        $format = null;

        // Match the following cases: field, alias.field, FUNC(field), FUNC(alias.field).
        preg_match( '/(?:(\w+)\()?\W*(?:(\w+)\.(\w+)|(\w+))/', $column, $match );

        // Alias & field.
        $count = count( $match );
        if ( $count == 4 ) {
            // Case: alias.field or FUNC(alias.field).
            $func  = $match[1];
            $alias = $match[2];
            $field = $match[3];
        } elseif ( $count == 5 ) {
            // Case: field or FUNC(field).
            $func  = $match[1];
            $alias = $this->alias;
            $field = $match[4];
        }

        // Format.
        if ( array_key_exists( $alias, $this->joins ) ) {
            $format = $this->joins[ $alias ]['schema'][ $field ]['format'];
        } elseif ( array_key_exists( $field, $this->schema ) ) {
            $format = $this->schema[ $field ]['format'];
        }

        return array( $func != '' ? "$func(`$alias`.`$field`)" : "`$alias`.`$field`", $format );
    }

}