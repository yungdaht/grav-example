<?php

/* modular/links.html.twig */
class __TwigTemplate_271f7d7c05784ce3bc2595108473f4e13617dbce0a30ae65db53079d42a40c96 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<section id=\"body-two\" style=\"background-color:antiquewhite\">
  <div class=\"wrapper padding\">
    <div class=\"links-container\">
      ";
        // line 4
        echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "content", array());
        echo "
    </div>
  </div>
</section>";
    }

    public function getTemplateName()
    {
        return "modular/links.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  24 => 4,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<section id=\"body-two\" style=\"background-color:antiquewhite\">
  <div class=\"wrapper padding\">
    <div class=\"links-container\">
      {{ page.content }}
    </div>
  </div>
</section>", "modular/links.html.twig", "/var/www/grav-admin/user/themes/custom-cave/templates/modular/links.html.twig");
    }
}
