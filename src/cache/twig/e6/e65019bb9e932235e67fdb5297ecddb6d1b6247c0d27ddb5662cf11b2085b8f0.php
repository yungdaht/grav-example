<?php

/* forgot.html.twig */
class __TwigTemplate_4bd878d2ecadb374a562d224c6817473342209c5b8d396b9274cebc96271a214 extends Twig_Template
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
        $this->loadTemplate("forgot.html.twig", "forgot.html.twig", 1, "2057519216")->display(array_merge($context, array("title" => "Grav Forgot Password")));
        // line 17
        echo "
";
    }

    public function getTemplateName()
    {
        return "forgot.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  21 => 17,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% embed 'partials/login.html.twig' with {title:'Grav Forgot Password'} %}

    {% block form %}
        {% for field in page.header.form.fields %}
            {% if field.type %}
                <div>
                    {% include [\"forms/fields/#{field.type}/#{field.type}.html.twig\", 'forms/fields/text/text.html.twig'] %}
                </div>
            {% endif %}
        {% endfor %}
        <div class=\"form-actions primary-accent\">
            <button type=\"submit\" class=\"button primary\" name=\"task\" value=\"forgot\"><i class=\"fa fa-paper-plane\"></i> {{ \"PLUGIN_ADMIN.LOGIN_BTN_SEND_INSTRUCTIONS\"|tu }}</button>
        </div>
    {% endblock %}

{% endembed %}

", "forgot.html.twig", "/var/www/grav-admin/user/plugins/admin/themes/grav/templates/forgot.html.twig");
    }
}


/* forgot.html.twig */
class __TwigTemplate_4bd878d2ecadb374a562d224c6817473342209c5b8d396b9274cebc96271a214_2057519216 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("partials/login.html.twig", "forgot.html.twig", 1);
        $this->blocks = array(
            'form' => array($this, 'block_form'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "partials/login.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_form($context, array $blocks = array())
    {
        // line 4
        echo "        ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "header", array()), "form", array()), "fields", array()));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["field"]) {
            // line 5
            echo "            ";
            if ($this->getAttribute($context["field"], "type", array())) {
                // line 6
                echo "                <div>
                    ";
                // line 7
                $this->loadTemplate(array(0 => (((("forms/fields/" . $this->getAttribute($context["field"], "type", array())) . "/") . $this->getAttribute($context["field"], "type", array())) . ".html.twig"), 1 => "forms/fields/text/text.html.twig"), "forgot.html.twig", 7)->display($context);
                // line 8
                echo "                </div>
            ";
            }
            // line 10
            echo "        ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['field'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 11
        echo "        <div class=\"form-actions primary-accent\">
            <button type=\"submit\" class=\"button primary\" name=\"task\" value=\"forgot\"><i class=\"fa fa-paper-plane\"></i> ";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('Grav\Plugin\Admin\AdminTwigExtension')->tuFilter("PLUGIN_ADMIN.LOGIN_BTN_SEND_INSTRUCTIONS"), "html", null, true);
        echo "</button>
        </div>
    ";
    }

    public function getTemplateName()
    {
        return "forgot.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  147 => 12,  144 => 11,  130 => 10,  126 => 8,  124 => 7,  121 => 6,  118 => 5,  100 => 4,  97 => 3,  80 => 1,  21 => 17,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% embed 'partials/login.html.twig' with {title:'Grav Forgot Password'} %}

    {% block form %}
        {% for field in page.header.form.fields %}
            {% if field.type %}
                <div>
                    {% include [\"forms/fields/#{field.type}/#{field.type}.html.twig\", 'forms/fields/text/text.html.twig'] %}
                </div>
            {% endif %}
        {% endfor %}
        <div class=\"form-actions primary-accent\">
            <button type=\"submit\" class=\"button primary\" name=\"task\" value=\"forgot\"><i class=\"fa fa-paper-plane\"></i> {{ \"PLUGIN_ADMIN.LOGIN_BTN_SEND_INSTRUCTIONS\"|tu }}</button>
        </div>
    {% endblock %}

{% endembed %}

", "forgot.html.twig", "/var/www/grav-admin/user/plugins/admin/themes/grav/templates/forgot.html.twig");
    }
}
