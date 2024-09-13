import { Component, Input } from '@angular/core';
import { FloatLabelModule } from 'primeng/floatlabel';
import { Telefonos } from '../../../domain/contactos.model';
import { FormsModule } from '@angular/forms';
import { ButtonModule } from 'primeng/button';
import { CommonModule } from '@angular/common';
import { InputTextModule } from 'primeng/inputtext';
import { TelefonosService } from '../../../services/telefonos/telefonos.service';
import { ConfirmationService, MessageService } from 'primeng/api';
import { ConfirmDialogModule } from 'primeng/confirmdialog';
import { ToastModule } from 'primeng/toast';

@Component({
  selector: 'app-telefonos',
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
  providers: [ConfirmationService, MessageService],
  templateUrl: './telefonos.component.html',
  styleUrl: './telefonos.component.css',
})
export class AppTelefonosComponent {
  title = 'Telefonos';
  @Input() telefonos: Telefonos[] = [];
  @Input() view = false;
  constructor(
    private telefonosService: TelefonosService,
    private confirmationService: ConfirmationService,
    private messageService: MessageService
  ) {}

  agregarTelefono() {
    this.telefonos.push({
      telefono: '',
    });
  }

  eliminarTelefono(telefono: Telefonos) {
    const id = telefono?.id ?? null;
    if (id) {
      this.confirmationService.confirm({
        header: 'Eliminar teléfono',
        message: '¿Está seguro de eliminar el teléfono?',
        icon: 'pi pi-info-circle',
        acceptButtonStyleClass: 'p-button-danger p-button-text',
        rejectButtonStyleClass: 'p-button-text p-button-text',
        acceptIcon: 'none',
        rejectIcon: 'none',
        accept: () => {
          this.telefonosService.deleteTelefono(id).subscribe(
            (response) => {
              const index = this.telefonos.findIndex((t) => t.id === id);
              this.telefonos.splice(index, 1);

              this.messageService.add({
                severity: 'success',
                summary: 'Teléfono eliminado',
                detail: 'El teléfono ha sido eliminado correctamente',
              });
            },
            (error) => {
              console.error(error);
            }
          );
        },
      });
      return;
    }

    const index = this.telefonos.findIndex((t) => t.id === id);
    this.telefonos.splice(index, 1);

    this.messageService.add({
      severity: 'success',
      summary: 'Teléfono eliminado',
      detail: 'El teléfono ha sido eliminado correctamente',
    });
  }
}
