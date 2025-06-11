<?php

namespace App\Services;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class FormOptimizationService
{
    /**
     * Classe CSS pour les formulaires optimisés
     */
    private const OPTIMIZED_FORM_CLASS = 'optimized-form';

    /**
     * Délai de validation en millisecondes
     */
    private const VALIDATION_DELAY = 500;

    /**
     * Convertit un formulaire en version optimisée
     */
    public function optimizeForm(string $formHtml): string
    {
        // Ajoute les classes et attributs nécessaires
        $formHtml = $this->addOptimizationAttributes($formHtml);

        // Ajoute le script d'optimisation
        $script = $this->generateOptimizationScript();

        return $formHtml . $script;
    }

    /**
     * Ajoute les attributs d'optimisation au formulaire
     */
    private function addOptimizationAttributes(string $formHtml): string
    {
        // Ajoute la classe d'optimisation
        $formHtml = str_replace('<form', '<form class="' . self::OPTIMIZED_FORM_CLASS . '"', $formHtml);

        // Ajoute l'attribut novalidate pour la validation côté client
        if (!str_contains($formHtml, 'novalidate')) {
            $formHtml = str_replace('<form', '<form novalidate', $formHtml);
        }

        return $formHtml;
    }

    /**
     * Génère le script d'optimisation
     */
    private function generateOptimizationScript(): string
    {
        return View::make('components.form-optimization-script')->render();
    }

    /**
     * Optimise un champ de formulaire
     */
    public function optimizeField(string $fieldHtml, array $options = []): string
    {
        $defaultOptions = [
            'validate' => true,
            'autocomplete' => true,
            'lazy' => false,
            'debounce' => self::VALIDATION_DELAY,
        ];

        $options = array_merge($defaultOptions, $options);

        // Ajoute les attributs d'optimisation
        $attributes = $this->buildFieldAttributes($options);
        $fieldHtml = $this->addAttributesToField($fieldHtml, $attributes);

        return $fieldHtml;
    }

    /**
     * Construit les attributs d'un champ
     */
    private function buildFieldAttributes(array $options): array
    {
        $attributes = [];

        if ($options['validate']) {
            $attributes['data-validate'] = 'true';
        }

        if ($options['autocomplete']) {
            $attributes['autocomplete'] = 'on';
        }

        if ($options['lazy']) {
            $attributes['data-lazy'] = 'true';
        }

        if ($options['debounce']) {
            $attributes['data-debounce'] = $options['debounce'];
        }

        return $attributes;
    }

    /**
     * Ajoute des attributs à un champ HTML
     */
    private function addAttributesToField(string $fieldHtml, array $attributes): string
    {
        $attributesString = collect($attributes)
            ->map(function ($value, $key) {
                return $key . '="' . htmlspecialchars($value) . '"';
            })
            ->implode(' ');

        return str_replace('<input', '<input ' . $attributesString, $fieldHtml);
    }

    /**
     * Génère un ID unique pour un champ
     */
    public function generateFieldId(string $name): string
    {
        return 'field_' . Str::slug($name) . '_' . Str::random(4);
    }

    /**
     * Ajoute des messages d'erreur personnalisés
     */
    public function addCustomErrorMessages(array $messages): string
    {
        return View::make('components.form-error-messages', ['messages' => $messages])->render();
    }
} 