<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年4月6日
*/
namespace CoreBundle\Model\Expr;

class CompositeExpression implements Expression
{
    const TYPE_AND = 'AND';
    const TYPE_OR = 'OR';

    /**
     * @var string
     */
    private $type;

    /**
     * @var Expression[]
     */
    private $expressions = array();

    /**
     * @param string $type
     * @param array  $expressions
     *
     * @throws \RuntimeException
     */
    public function __construct($type, array $expressions)
    {
        $this->type = $type;

        foreach ($expressions as $expr) {
            if ($expr instanceof Value) {
                throw new \RuntimeException("Values are not supported expressions as children of and/or/between expressions.");
            }
            if ( ! ($expr instanceof Expression)) {
                throw new \RuntimeException("No expression given to CompositeExpression.");
            }

            $this->expressions[] = $expr;
        }
    }

    /**
     * Returns the list of expressions nested in this composite.
     *
     * @return Expression[]
     */
    public function getExpressionList()
    {
        return $this->expressions;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritDoc}
     */
    public function visit(ExpressionVisitor $visitor)
    {
        return $visitor->walkCompositeExpression($this);
    }
}