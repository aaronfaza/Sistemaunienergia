<?php

namespace App\Models\Concerns;

use App\Models\DocumentAuditLog;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Registra en document_audit_logs quién crea, modifica y elimina cada
 * registro, y sella created_by/updated_by automáticamente. Pensado para
 * documentos sujetos a fiscalización (compras, cartas, requerimientos).
 */
trait Auditable
{
    public static function bootAuditable()
    {
        static::creating(function ($model) {
            $model->created_by = $model->created_by ?? auth()->id();
            $model->updated_by = auth()->id();
        });

        static::updating(function ($model) {
            $model->updated_by = auth()->id();
        });

        static::created(function ($model) {
            $model->recordAudit('creado', $model->getAttributes());
        });

        static::updated(function ($model) {
            $changes = $model->getChanges();
            unset($changes['updated_at'], $changes['updated_by']);

            if (empty($changes)) {
                return;
            }

            $model->recordAudit('actualizado', $changes);
        });

        static::deleted(function ($model) {
            $model->recordAudit('eliminado', $model->getOriginal());
        });
    }

    public function auditLogs(): MorphMany
    {
        return $this->morphMany(DocumentAuditLog::class, 'auditable')->latest('id');
    }

    protected function recordAudit(string $accion, ?array $cambios): void
    {
        DocumentAuditLog::create([
            'auditable_type' => static::class,
            'auditable_id' => $this->getKey(),
            'user_id' => auth()->id(),
            'accion' => $accion,
            'cambios' => $cambios,
            'created_at' => now(),
        ]);
    }
}
