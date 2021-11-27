<?php

namespace App;

class TransactionStatus
{
    static function HirerGetColorByStatus($status)
    {
        switch ($status) {
            case TransactionStatus::APPLIED_DISMISSED:
            case TransactionStatus::INTERVIEW_REQUESTED_REJECTED:
            case TransactionStatus::INTERVIEWING_REJECTED:
                return 'text-danger';
            case TransactionStatus::INTERVIEWING:
                return 'text-info';
            case TransactionStatus::ACCEPTED:
                return 'text-success';
            default:
                return 'text-dark';
        }
    }

    static function HirerGetNameOfStatus($status)
    {
        switch ($status) {
            case TransactionStatus::APPLIED:
                return 'Applied';
            case TransactionStatus::APPLIED_DISMISSED:
                return 'Dismissed';
            case TransactionStatus::INTERVIEW_REQUESTED:
                return 'Requested Interview!';
            case TransactionStatus::INTERVIEW_REQUESTED_REJECTED:
            case TransactionStatus::INTERVIEWING_REJECTED:
                return 'Rejected';
            case TransactionStatus::INTERVIEWING:
                return 'In the interview!';
            case TransactionStatus::ACCEPTED:
                return 'Accepted!';
            default:
                return 'Unrecognizable status!';
        }
    }

    static function CandidateGetNameOfStatus($status)
    {
        switch ($status) {
            case TransactionStatus::APPLIED:
                return '<div class="card-header bg-warning border-warning text-white font-weight-bold">Wait for a response!</div>
                <div class="card-body mx-3 mb-3">';
            case TransactionStatus::INTERVIEW_REQUESTED:
                return '<div class="card-header bg-info border-info text-white font-weight-bold">You have been invited for an interview!</div>
                <div class="card-body mx-3 mb-3">';
            case TransactionStatus::INTERVIEWING:
                return '<div class="card-header bg-secondary border-secondary text-white font-weight-bold">Attend the interview and wait for a response!</div>
                <div class="card-body mx-3 mb-3">';
            case TransactionStatus::ACCEPTED:
                return '<div class="card-header bg-success border-success text-white font-weight-bold">You have been accepted!</div>
                <div class="card-body mx-3 mb-3">';
            default:
                return '<div class="card-header bg-danger border-danger text-white font-weight-bold">You have been rejected!</div>
                <div class="card-body mx-3 mb-3">';
        }
    }

    static function HirerGetButtonsOfStatus($status, $id)
    {
        switch ($status) {
            case TransactionStatus::APPLIED:
                return '<button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#Confirmation" wire:click="edit('.$id.', 1)">Dismiss</button>
                <button type="button" class="btn btn-outline-info ml-lg-2" data-toggle="modal" data-target="#Confirmation" wire:click="edit('.$id.', 0)">Interview</button>';
            case TransactionStatus::INTERVIEW_REQUESTED:
                return '<button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#Confirmation" wire:click="edit('.$id.', 1)">Fail</button>';
            case TransactionStatus::INTERVIEWING:
                return '<button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#Confirmation" wire:click="edit('.$id.', 1)">Fail</button><button type="button" class="btn btn-outline-success ml-lg-2" data-target="#Confirmation" wire:click="edit('.$id.', 2)">Accept</button>';
            default:
                return '';
        }
    }

    static function CandidateGetButtonsOfStatus($status, $id)
    {
        switch ($status) {
            case TransactionStatus::APPLIED:
            case TransactionStatus::INTERVIEWING:
                return '<a class="btn btn-danger d-block mb-2 cancel-btn" data-toggle="modal" data-target="#Confirmation" wire:click="edit('.$id.', 1)">Cancel</a>';
            case TransactionStatus::INTERVIEW_REQUESTED:
                return '<a class="btn btn-info d-block mb-2 action-btn" data-toggle="modal" data-target="#Confirmation" wire:click="edit('.$id.', 0)">Accept interview</a><a class="btn btn-danger d-block mb-2 cancel-btn" data-toggle="modal" data-target="#Confirmation" wire:click="edit('.$id.', 1)">Cancel</a>';
            default:
                return '';
        }
    }

    static function UpgradeStatus($status, $isDeny){
        if ($isDeny == 1) // Deny / Cancel the application
            return $status + 1;
        else 
            return $status + 2;
    }

    public const APPLIED = 0;
    public const APPLIED_DISMISSED = 1;
    public const INTERVIEW_REQUESTED = 2;
    public const INTERVIEW_REQUESTED_REJECTED = 3;
    public const INTERVIEWING = 4;
    public const INTERVIEWING_REJECTED = 5;
    public const ACCEPTED = 6;
}
