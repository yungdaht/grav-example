<?php

/* animals.html.twig */
class __TwigTemplate_1c9d19fd110b1dbb5eee604a3f6265a7cbd32b63a203ce835dbf14919429991a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("partials/base.html.twig", "animals.html.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "partials/base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "  <div class=\"wrapper padding\">
    ";
        // line 5
        echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "content", array());
        echo "
  </div>
";
    }

    public function getTemplateName()
    {
        return "animals.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  34 => 5,  31 => 4,  28 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends 'partials/base.html.twig' %}

{% block content %}
  <div class=\"wrapper padding\">
    {{ page.content }}
  </div>
{% endblock %}", "animals.html.twig", "/var/www/grav-admin/user/themes/custom-cave/templates/animals.html.twig");
    }
}
