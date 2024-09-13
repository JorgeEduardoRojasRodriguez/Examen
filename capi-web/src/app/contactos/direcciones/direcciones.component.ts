import { Component, Input } from '@angular/core';
import { FloatLabelModule } from 'primeng/floatlabel';
import { Direcciones } from '../../../domain/contactos.model';
import { FormsModule } from '@angular/forms';
import { ButtonModule } from 'primeng/button';
import { CommonModule } from '@angular/common';
import { InputTextModule } from 'primeng/inputtext';
import { ToastModule } from 'primeng/toast';
import { ConfirmDialogModule } from 'primeng/confirmdialog';
import { DireccionesService } from '../../../services/direcciones/direcciones.service';
import { ConfirmationService, MessageService } from 'primeng/api';

@Component({
  selector: 'app-direcciones',
  standalone: true,
  imports: [
    FloatLabelModule,
    FormsModule,
    ButtonModule,
    InputTextModule,
    CommonModule,
    ConfirmDialogModule,
    ToastModule,
  ],
  providers: [MessageService, ConfirmationService],
  templateUrl: './direcciones.component.html',
  styleUrl: './direcciones.component.css',
})
export class AppDireccionesComponent {
  title = 'direcciones';
  @Input() direcciones: Direcciones[] = [];
  @Input() view = false;
  constructor(
    private direccionesService: DireccionesService,
    private confirmationService: ConfirmationService,
    private messageService: MessageService
  ) {}

  agregarDirecciones() {
    this.direcciones.push({
      calle: '',
      numero: '',
      colonia: '',
      ciudad: '',
      codigo_postal: '',
      estado: '',
      pais: '',
    });
  }

  eliminardirecciones(direcciones: Direcciones) {
    const id = direcciones?.id ?? null;
    if (id) {
      this.confirmationService.confirm({
        header: 'Eliminar dirección',
        message: '¿Está seguro de eliminar la dirección?',
        icon: 'pi pi-info-circle',
        acceptButtonStyleClass: 'p-button-danger p-button-text',
        rejectButtonStyleClass: 'p-button-text p-button-text',
        acceptIcon: 'none',
        rejectIcon: 'none',
        accept: () => {
          this.direccionesService.deleteDirecciones(id).subscribe(
            () => {
              const index = this.direcciones.findIndex((t) => t.id === id);
              this.direcciones.splice(index, 1);

              this.messageService.add({
                severity: 'success',
                summary: 'Direccion eliminada',
                detail: 'La direccion ha sido eliminado correctamente',
              });
            },
            (error: any) => {
              console.error(error);
            }
          );
        },
      });
      return;
    }

    const index = this.direcciones.findIndex((t) => t.id === id);
    this.direcciones.splice(index, 1);

    this.messageService.add({
      severity: 'success',
      summary: 'Direccion eliminada',
      detail: 'La direccion ha sido eliminado correctamente',
    });
  }
}
