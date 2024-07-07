<?php

namespace App\ViewModels\Backoffice\Categories;

use App\Constants\Heroicons;
use App\Enums\Filters\CategoryFilters;
use App\Filters\FilterValue;
use App\Helpers\RequestHelper;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Overrides\LengthAwarePaginator;
use App\Services\Frontend\ButtonGenerator;
use App\Services\Frontend\FormActionGenerator;
use App\Services\Frontend\FormFieldsGenerator;
use App\Services\Frontend\ModalGenerator;
use App\Services\Frontend\ResourceDetailGenerator;
use App\Services\Frontend\TableGenerator;
use App\Services\Frontend\UIElements\ActionForm;
use App\Services\Frontend\UIElements\Buttons\Button;
use App\Services\Frontend\UIElements\ColumnItems\ActionColumn;
use App\Services\Frontend\UIElements\ColumnItems\ActionsColumn;
use App\Services\Frontend\UIElements\ColumnItems\BooleanColumn;
use App\Services\Frontend\UIElements\ColumnItems\DateColumn;
use App\Services\Frontend\UIElements\ColumnItems\TextColumn;
use App\Services\Frontend\UIElements\FormFields\CheckboxField;
use App\Services\Frontend\UIElements\FormFields\DateField;
use App\Services\Frontend\UIElements\FormFields\SelectField;
use App\Services\Frontend\UIElements\FormFields\SelectOptions\BooleanOptions;
use App\Services\Frontend\UIElements\FormFields\TextareaField;
use App\Services\Frontend\UIElements\FormFields\TextField;
use App\Services\Frontend\UIElements\Modals\Modal;
use App\Services\Frontend\UIElements\ResourceDetailLine;
use App\Services\ViewModels\FilterService;
use App\Traits\ViewModels\WithPerPage;
use App\ViewModels\Contracts\Datatable;
use App\ViewModels\ViewModel;
use Exception;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Log;


final class GetCategoriesViewModel extends ViewModel implements Datatable
{
    use WithPerPage;

    const PER_PAGE = 1;

    const ROUTE_BACKOFFICE_CATEGORIES_STORE = 'backoffice.categories.store';

    const ROUTE_BACKOFFICE_CATEGORIES_GENERATE_EXPORT_URL = 'backoffice.categories.generate_export_url';

    public function __construct(
        private readonly Pipeline $pipeline,
        private readonly TableGenerator $tableGenerator,
        private readonly FilterService $filterService,
        private readonly ButtonGenerator $buttonGenerator,
        private readonly FormActionGenerator $formActionGenerator,
        private readonly ModalGenerator $modalGenerator,
        private readonly ResourceDetailGenerator $resourceDetailGenerator,
        public readonly bool $paginated = true,
    )
    {
        $this->tableGenerator->initSorter(
            request(
                key: 'sorter',
                default: [
                    'column' => 'created_at',
                    'direction' => 'desc',
                ]
            )
        );
    }

    public function title(): string
    {
        return __('Categorías de cursos');
    }
    public function textModel(): string
    {
        return __('Categoría de curso');
    }

    public function tableColumns(): array
    {
        return $this->tableGenerator
            ->addColumn(
                new TextColumn(
                    label: __('Nombre'),
                    key: 'name',
                    sortable: true,
                    direction: $this->tableGenerator->getSortDirection(column: 'name')
                )
            )->addColumn(
                new BooleanColumn(
                    label: __('Activa'),
                    key: 'is_active',
                    sortable: true,
                    direction: $this->tableGenerator->getSortDirection(column: 'is_active'),
                    trueValue: 'Si',
                    falseValue: 'No',
                )
            )->addColumn(
                new DateColumn(
                    label: __('Fecha de creacíón'),
                    key: 'created_at_iso_format_ll',
                    sortable: true,
                    direction: $this->tableGenerator->getSortDirection(column: 'created_at'),
                    sortKey: 'created_at',
                )
            )->addColumn(
                new ActionsColumn(
                    label: __('Acciones'),
                    key: 'actions',
                    actions: [
                        new ActionColumn(
                            label: __('Ver'),
                            class: ButtonGenerator::SHOW_CSS_CLASS,
                            event: 'show,'
                        ),
                        new ActionColumn(
                            label: __('Editar'),
                            class: ButtonGenerator::EDIT_CSS_CLASS,
                            event: 'edit,'
                        ),
                        new ActionColumn(
                            label: __('Eliminar'),
                            class: ButtonGenerator::DELETE_CSS_CLASS,
                            event: 'remove,'
                        ),
                    ]
                )
            )
            ->getColumns();
    }

    protected function tableFilters(): array
    {
        return array_merge(
            $this->filterService->generateSorterFilter(key: 'sorter'),
            $this->filterService->generateNormalFilter(key: 'query'),
            $this->filterService->generateNormalFilter(key: 'is_active'),
        );
    }
    public function tableData(): ResourceCollection|LengthAwarePaginator
    {
        $models = $this->pipeline
            ->send(Category::query())
            ->through(
                collect($this->tableFilters())
                    ->map(fn ($filter, $value) => CategoryFilters::from($value)->create(filter: new FilterValue($filter)))
                    ->values()
                    ->all()
            )->thenReturn();

        if ($this->paginated)
        {
            return CategoryResource::collection($models->paginate($this->perPage(self::PER_PAGE)))->resource;
        }

        return CategoryResource::collection($models->get());
    }

    public function tableButtons(): array
    {
        return $this->buttonGenerator
            ->addButton(
                new Button(
                    label: 'Crear categoria de curso',
                    action: 'create',
                    icon: Heroicons::PLUS,
                    class: ButtonGenerator::CREATE_INLINE_CSS_CLASS,
                )
            )->addButton(
                new Button(
                    label: 'Exportar',
                    action: 'export',
                    icon: Heroicons::DOWNLOAD,
                    class: ButtonGenerator::EXPORT_INLINE_CSS_CLASS,
                )
            )
            ->getButtons();
    }

    /**
     * @throws Exception
     */
    protected function formFields(): array
    {
        return app(FormFieldsGenerator::class)
            ->addField(
                new TextField(
                    name: 'name',
                    label: __('Nombre'),
                    placeholder: __('Nombre'),
                )
            )
            ->addField(
                new TextareaField(
                    name: 'description',
                    label: 'Descripción',
                    placeholder: 'Descripción',
                    row: 5,
                )
            )
            ->addField(
                new DateField(
                    name: 'created_at',
                    label: 'Fecha de creación',
                )
            )
            ->addField(
                new CheckboxField(
                    name: 'is_active',
                    label: '¿Está Activa?',
                )
            )
            ->getFields();

    }

    protected function resourceDetailConfig(): array
    {
        return $this->resourceDetailGenerator
            ->addLine(
                new ResourceDetailLine(
                    columnName: 'name',
                    label: __('Nombre'),
                )
            )
            ->addLine(
                new ResourceDetailLine(
                    columnName: 'description',
                    label: __('Descripción')
                )

            )
            ->addLine(
                new ResourceDetailLine(
                    columnName: 'created_at_iso_format_ll',
                    label: __('Fecha de creación'),
                )
            )
            ->addLine(
                new ResourceDetailLine(
                    columnName: 'is_Active',
                    label: __('¿Está activa?'),
                    isBoolean: true,
                )
            )
            ->getLines();
    }

    public function modals(): array
    {
        try {
            $formFields = $this->formFields();
            return $this->modalGenerator
                ->addModals(
                    new Modal(
                        type: ModalGenerator::MODAL_CREATE,
                        title: 'Crear categoría de curso',
                        textSubmitButton: 'Crear',
                        action: $this->formActionGenerator->setActionForm(
                            new ActionForm(
                                url: route(self::ROUTE_BACKOFFICE_CATEGORIES_STORE),
                                method:FormActionGenerator::HTTP_METHOD_POST,
                            )
                        )->getActionForm(),
                        formFields: $formFields,
                    ),
                    new Modal(
                        type: ModalGenerator::MODAL_SHOW,
                        title: 'Información de la categoria del curso',
                        extraData: [
                            'resource_detail_config' => $this->resourceDetailConfig(),
                        ],

                    ),
                    new Modal(
                        type: ModalGenerator::MODAL_EDIT,
                        title: 'Editar categoría de curso',
                        textSubmitButton: 'Editar',
                        formFields: $formFields,
                    ),
                    new Modal(
                        type: ModalGenerator::MODAL_EXPORT,
                        title: 'Exportar categoría de curso',
                        textSubmitButton: 'Exportar',
                        action: $this->formActionGenerator->setActionForm(
                            new ActionForm(
                                url: route(
                                    self::ROUTE_BACKOFFICE_CATEGORIES_GENERATE_EXPORT_URL,
                                    RequestHelper::queryWithoutNulls()
                                ),
                            )
                        )->getActionForm(),
                        questionMessage: '¿Estas seguro de que quieres exportar estas categorias de curso?'
                    ),
                    new Modal(
                        type: ModalGenerator::MODAL_DELETE,
                        title: 'Eliminar categoría de curso',
                        textSubmitButton: 'Eliminar',
                        questionMessage: '¿Estas seguro de que quieres eliminar estas categorias de curso?',
                        textCancelButton: 'Cancelar',
                    ),
                )
                ->getModals();
        }catch (Exception $exception) {
            Log::error('Error al general los modales de las categorias: ' . $exception->getMessage());
            return [];
        }
    }

    public function filterFields(): array
    {
        return app(FormFieldsGenerator::class)
            ->addField(
                new SelectField(
                    name: 'query',
                    label: __('Buscador'),
                    placeholder: __('Buscar'),
                )
            )
            ->addField(
                new SelectField(
                    name: 'is_Active',
                    label: __('¿Está activa?'),
                    placeholder: __('Selecciona una opción'),
                    options: (new BooleanOptions())->getOptions()
                )

            )
            ->getFields();
    }
}
