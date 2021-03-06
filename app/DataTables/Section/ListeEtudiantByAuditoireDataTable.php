<?php

namespace App\DataTables\Section;

use App\Models\Etudiant;
use Yajra\DataTables\Services\DataTable;

class ListeEtudiantByAuditoireDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn('action', function($query){
                return '<button type="button" class="edit-modal btn btn-primary" data-toggle="modal" data-target="#editModal" data-info="'.$query->idetudiants.','.$query->matricule.','.$query->nom.','.$query->postnom.','.$query->prenom.','.$query->idauditoires.'">
                      <span class="fas fa-edit"> </span>
                    </button>'

                     .'  '.
                    '<button type="button" class="edit-modal btn btn-danger" data-toggle="modal" data-target="#Modal" data-info="'.$query->idcours.','.$query->lib.','.$query->ponderation.','.$query->idetudiants.','.$query->idauditoires.'">
                      <span class=" fas fa-trash"> </span>
                    </button>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Etudiant $model)
    {
        return $model::EtudiantParAuditoire($this->idauditoires)
                        ->EtudiantActif()
                        ->get([
                        'idetudiants',
                        'matricule',
                        'nom',
                        'postnom',
                        'prenom',
                        'idauditoires',
                    ]);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->addAction(['printable' => false, 'width' => '120px'])
                    ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'matricule',
            'nom',
            'postnom',
            'prenom',
            
        ];
    }

    protected function getBuilderParameters(){
        return [
            'order' => [[1,'Asc']]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Comptabilite/Liste_Etudiants' . date('YmdHis');
    }
}
