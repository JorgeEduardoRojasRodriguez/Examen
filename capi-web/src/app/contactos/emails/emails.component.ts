import { Component, Input } from '@angular/core';
import { FloatLabelModule } from 'primeng/floatlabel';
import { Emails } from '../../../domain/contactos.model';
import { FormsModule } from '@angular/forms';
import { ButtonModule } from 'primeng/button';
import { CommonModule } from '@angular/common';
import { InputTextModule } from 'primeng/inputtext';
import { ConfirmationService, MessageService } from 'primeng/api';
import { EmailsService } from '../../../services/emails/emails.service';
import { ConfirmDialogModule } from 'primeng/confirmdialog';
import { ToastModule } from 'primeng/toast';

@Component({
  selector: 'app-emails',
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
  templateUrl: './emails.component.html',
  styleUrl: './emails.component.css',
})
export class AppEmailsComponent {
  title = 'Email';
  @Input() emails: Emails[] = [];
  @Input() view = false;
  constructor(
    private emailService: EmailsService,
    private confirmationService: ConfirmationService,
    private messageService: MessageService
  ) {}

  agregaremails() {
    this.emails.push({
      email: '',
    });
  }

  eliminarEmail(email: Emails) {
    const id = email?.id ?? null;
    if (id) {
      this.confirmationService.confirm({
        header: 'Eliminar email',
        message: '¿Está seguro de eliminar el email?',
        icon: 'pi pi-info-circle',
        acceptButtonStyleClass: 'p-button-danger p-button-text',
        rejectButtonStyleClass: 'p-button-text p-button-text',
        acceptIcon: 'none',
        rejectIcon: 'none',
        accept: () => {
          this.emailService.deleteEmails(id).subscribe(
            () => {
              const index = this.emails.findIndex((t) => t.id === id);
              this.emails.splice(index, 1);

              this.messageService.add({
                severity: 'success',
                summary: 'Email eliminado',
                detail: 'El email ha sido eliminado correctamente',
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

    const index = this.emails.findIndex((t) => t.id === id);
    this.emails.splice(index, 1);

    this.messageService.add({
      severity: 'success',
      summary: 'Email eliminado',
      detail: 'El email ha sido eliminado correctamente',
    });
  }
}
