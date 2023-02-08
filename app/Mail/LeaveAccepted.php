<?php

namespace App\Mail;

use App\Models\Leave;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeaveAccepted extends Mailable {
	use Queueable, SerializesModels;

	private Leave $leave;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(Leave $leave) {
		$this->leave = $leave;
	}

	/**
	 * Get the message envelope.
	 *
	 * @return \Illuminate\Mail\Mailables\Envelope
	 */
	public function envelope() {
		return new Envelope(from: new Address('system@eclick.hu', 'System User'), subject: 'Leave Accepted',);
	}

	/**
	 * Get the message content definition.
	 *
	 * @return \Illuminate\Mail\Mailables\Content
	 */
	public function content() {
		return new Content(view: 'emails.leave.accepted', with: [
			'leave' => $this->leave
		]);
	}

	/**
	 * Get the attachments for the message.
	 *
	 * @return array
	 */
	public function attachments() {
		return [];
	}
}
